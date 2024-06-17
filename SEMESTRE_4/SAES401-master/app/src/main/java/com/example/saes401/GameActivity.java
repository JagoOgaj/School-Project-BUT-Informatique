package com.example.saes401;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;

import androidx.appcompat.app.AppCompatActivity;

import com.example.saes401.db.DataModel;
import com.example.saes401.db.DatabaseHelper;
import com.example.saes401.entities.Player;
import com.example.saes401.helper.GameConstant;
import com.example.saes401.helper.GameSave;
import com.example.saes401.helper.JsonReader;
import com.example.saes401.helper.Utilities;
import com.example.saes401.story.Story;
import com.example.saes401.utilities.Inventory;

public class GameActivity extends AppCompatActivity implements Utilities {
    private Intent intent;
    private Player playerInstance;
    private int currentLevel;
    private int currentEnemieInstance;
    private String previousActivity;
    private Boolean gameContinue;
    private Boolean levelStart;
    private DataModel dataModel;
    private boolean isEndFight;
    private Inventory inventoryEnemie;

    @Override
    protected void onCreate(Bundle bundle) {
        super.onCreate(bundle);
        intent = getIntent();
        if (intent != null) {
            this.initAttibuts();
            this.initStartActivity();
        }
        hideSystemUI();
    }

    private void initStartActivity() {
        if(this.previousActivity.contains(GameConstant.VALUE_GAME_CONTINUE)) {
            this.playerInstance = GameSave.loadPlayer(this);
            this.currentLevel = GameSave.loadLevel(this);
            this.currentEnemieInstance = GameSave.loadCurrentEnemyIndex(this);
            this.levelStart = GameSave.loadLevelStart(this);
            this.gameContinue = GameSave.loadPlayerWin(this);
            this.isEndFight = GameSave.loadEndFight(this);
            this.inventoryEnemie = GameSave.loadEnemieInventory(this);
            if (GameSave.loadPreviousActivity(this).contains(GameConstant.VALUE_GAME_CHOISE))
                startActivityGameChoise();
            else if (GameSave.loadPreviousActivity(this).contains(GameConstant.VALUE_GAME_NARATION))
                startActivityGameNaration();
            else if (GameSave.loadPreviousActivity(this).contains(GameConstant.VALUE_STORY))
                statActivityStory();
            else
                startActivityPlayerChoise();
        }
        // Nartion -> GameChoise -> Story
        else if (this.previousActivity.contains(GameConstant.VALUE_PLAYER_CHOISE)) {
            startActivityGameNaration();
        } else if (this.previousActivity.contains(GameConstant.VALUE_STORY)) {
            if (this.currentLevel > 3) {
                GameSave.clearGameSaveKeys(this);
                startResultat();
            }
            if (gameContinue) {
                  if (!noEnemieLeft(this.currentEnemieInstance)) {
                    this.currentEnemieInstance++;
                    this.levelStart = false;

                } else if (noEnemieLeft(this.currentEnemieInstance)) {
                    this.currentLevel++;
                    this.currentEnemieInstance = 0;
                    this.levelStart = true;
                }
            }
            startActivityGameNaration();
        } else if (this.previousActivity.contains(GameConstant.VALUE_GAME_CHOISE)) {
            statActivityStory();
        } else if (this.previousActivity.contains(GameConstant.VALUE_GAME_NARATION)) {
            if (this.currentLevel > 3 || !this.gameContinue) {
                setDataToDB();
                GameSave.clearGameSaveKeys(this);
                startResultat();
            } else startActivityGameChoise();

        }
    }

    private void setDataToDB() {
        this.dataModel.setDatabaseHelper(new DatabaseHelper(this));
        //add last data
        this.dataModel.addEnd();
        String test = String.format(GameConstant.FORMAT_CURRENT_LEVEL, this.currentLevel, this.currentEnemieInstance);
        this.dataModel.addLastScore(test);
        this.dataModel.addWin(this.currentLevel > 3 && noEnemieLeft(this.currentEnemieInstance));
        //put data to db
        this.dataModel.putAllData();
    }

    private boolean noEnemieLeft(int index) {
        boolean enemieLeft = false;
        try {
            enemieLeft = JsonReader.getNumberEnemies(this, String.format(GameConstant.FORMAT_LEVEL, this.currentLevel)) == index;
        } catch (Exception e) {
            Log.d("GameActivity", "enemieLeftError: " + e.getMessage());
        }
        return enemieLeft;
    }

    @Override
    public void initAttibuts() {
        this.currentEnemieInstance = intent.getIntExtra(GameConstant.KEY_ENEMIE_INDEX, 0);
        this.gameContinue = intent.getBooleanExtra(GameConstant.KEY_PLAYER_WIN, false);
        this.levelStart = intent.getBooleanExtra(GameConstant.KEY_START_LEVEL, false);
        this.playerInstance = intent.getParcelableExtra(GameConstant.KEY_PLAYER);
        this.currentLevel = intent.getIntExtra(GameConstant.KEY_LEVEL, 0);
        this.previousActivity = intent.getStringExtra(GameConstant.KEY_PREVIOUS_ACTIVITY);
        this.dataModel = intent.getParcelableExtra(GameConstant.KEY_DATA_MODEL) == null ? new DataModel() : intent.getParcelableExtra(GameConstant.KEY_DATA_MODEL);
    }

    @Override
    protected void onRestoreInstanceState(Bundle savedInstanceState) {
        super.onRestoreInstanceState(savedInstanceState);
        currentLevel = savedInstanceState.getInt(GameConstant.KEY_LEVEL);
        playerInstance = savedInstanceState.getParcelable(GameConstant.KEY_PLAYER);
        currentEnemieInstance = savedInstanceState.getInt(GameConstant.KEY_ENEMIE_INDEX);
        previousActivity = savedInstanceState.getString(GameConstant.KEY_PREVIOUS_ACTIVITY);
        gameContinue = savedInstanceState.getBoolean(GameConstant.KEY_PLAYER_WIN);
        levelStart = savedInstanceState.getBoolean(GameConstant.KEY_START_LEVEL);
        this.dataModel = savedInstanceState.getParcelable(GameConstant.KEY_DATA_MODEL);
    }

    @Override
    protected void onSaveInstanceState(Bundle outState) {
        super.onSaveInstanceState(outState);
        outState.putInt(GameConstant.KEY_LEVEL, this.currentLevel);
        outState.putParcelable(GameConstant.KEY_PLAYER, this.playerInstance);
        outState.putInt(GameConstant.KEY_ENEMIE_INDEX, this.currentEnemieInstance);
        outState.putString(GameConstant.KEY_PREVIOUS_ACTIVITY, this.previousActivity);
        outState.putBoolean(GameConstant.KEY_PLAYER_WIN, this.gameContinue);
        outState.putBoolean(GameConstant.KEY_START_LEVEL, this.levelStart);
        outState.putParcelable(GameConstant.KEY_DATA_MODEL, this.dataModel);
    }

    @Override
    public void startActivityGameChoise() {
        this.intent = new Intent(this, GameChoise.class);
        putExtra();
        startActivity(this.intent);
    }

    @Override
    public void startActivityGameNaration() {
        this.intent = new Intent(this, GameNaration.class);
        putExtra();
        startActivity(this.intent);
    }

    @Override
    public void statActivityStory() {
        this.intent = new Intent(this, Story.class);
        putExtra();
        startActivity(this.intent);
    }

    private void startResultat() {
        this.intent = new Intent(this, ResultatActivity.class);
        this.intent.putExtra(GameConstant.KEY_PLAYER_WIN, this.gameContinue);
        startActivity(this.intent);
    }

    private void putExtra() {
        this.intent.putExtra(GameConstant.KEY_PLAYER, this.playerInstance);
        this.intent.putExtra(GameConstant.KEY_LEVEL, this.currentLevel);
        this.intent.putExtra(GameConstant.KEY_ENEMIE_INDEX, this.currentEnemieInstance);
        this.intent.putExtra(GameConstant.KEY_START_LEVEL, this.levelStart);
        this.intent.putExtra(GameConstant.KEY_PLAYER_WIN, this.gameContinue);
        this.intent.putExtra(GameConstant.KEY_DATA_MODEL, this.dataModel);
        this.intent.putExtra(GameConstant.KEY_INVENTORY_ENEMIE, this.inventoryEnemie);
        this.intent.putExtra(GameConstant.KEY_END_FIGHT, this.isEndFight);
    }

    @Override
    public void startActivityGame() {
        //void
    }

    @Override
    public void startActivityPlayerChoise() {
       this.intent = new Intent(this, PlayerChoise.class);
       putExtra();
       startActivity(this.intent);
    }

    @Override
    public void setListener() {

    }@Override
    public void onWindowFocusChanged(boolean hasFocus) {
        super.onWindowFocusChanged(hasFocus);
        if (hasFocus) {
            hideSystemUI();
        }
    }

    private void hideSystemUI() {
        // Activer le mode immersif
        View decorView = getWindow().getDecorView();
        decorView.setSystemUiVisibility(
                View.SYSTEM_UI_FLAG_IMMERSIVE_STICKY
                        | View.SYSTEM_UI_FLAG_LAYOUT_STABLE
                        | View.SYSTEM_UI_FLAG_LAYOUT_HIDE_NAVIGATION
                        | View.SYSTEM_UI_FLAG_LAYOUT_FULLSCREEN
                        | View.SYSTEM_UI_FLAG_HIDE_NAVIGATION
                        | View.SYSTEM_UI_FLAG_FULLSCREEN);
    }

    private void showSystemUI() {
        // Afficher la barre de navigation et la barre de statut
        View decorView = getWindow().getDecorView();
        decorView.setSystemUiVisibility(
                View.SYSTEM_UI_FLAG_LAYOUT_STABLE
                        | View.SYSTEM_UI_FLAG_LAYOUT_HIDE_NAVIGATION
                        | View.SYSTEM_UI_FLAG_LAYOUT_FULLSCREEN);
    }

}
