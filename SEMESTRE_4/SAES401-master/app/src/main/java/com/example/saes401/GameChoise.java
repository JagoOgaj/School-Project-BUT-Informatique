package com.example.saes401;

import android.content.ComponentName;
import android.content.Intent;
import android.content.ServiceConnection;
import android.graphics.Color;
import android.graphics.Typeface;
import android.os.Bundle;
import android.os.IBinder;
import android.text.Spannable;
import android.text.SpannableString;
import android.text.style.ForegroundColorSpan;
import android.text.style.StyleSpan;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

import com.example.saes401.db.DataModel;
import com.example.saes401.entities.Player;
import com.example.saes401.helper.GameConstant;
import com.example.saes401.helper.GameSave;
import com.example.saes401.helper.JsonReader;
import com.example.saes401.helper.Utilities;
import com.example.saes401.service.ClickSound;
import com.example.saes401.utilities.Item;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

public class GameChoise extends AppCompatActivity implements Utilities {

    private Intent intent;
    private Player playerInstance;
    private int currentLevel;
    private TextView textLevel;
    private LinearLayout choiseBeforeLevel;
    private ImageButton imageButton1;
    private ImageButton imageButton2;
    private ImageButton imageButton3;
    private Button buttonContinueToLevel;
    private ImageButton selectedButton = null;
    private int currentEnemieIndex;
    private boolean levelStart;
    private boolean gameContinue;
    private DataModel dataModel;
    private boolean isBound = false;
    private ClickSound clickSoundService;
    private JSONObject[] infoButton = new JSONObject[3];
    private ServiceConnection serviceConnection = new ServiceConnection() {
        @Override
        public void onServiceConnected(ComponentName name, IBinder service) {
            ClickSound.LocalBinder binder = (ClickSound.LocalBinder) service;
            clickSoundService = binder.getService();
            isBound = true;
        }
        @Override
        public void onServiceDisconnected(ComponentName name) {
            isBound = false;
        }
    };

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_choise);
        intent = getIntent();
        if (intent != null) {
            initAttibuts();
        }
        try {
            initFront();
        } catch (Exception e) {
            Log.d("error -> initFront", e.getMessage());
        }
        setListener();
        hideSystemUI();
    }

    @Override
    protected void onStart() {
        super.onStart();
        initSoundService();
    }

    @Override
    protected void onStop() {
        super.onStop();
        if (isBound) {
            unbindService(serviceConnection);
            isBound = false;
        }
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        GameSave.saveGame(
                this,
                this.currentLevel,
                this.playerInstance,
                this.currentEnemieIndex,
                this.levelStart,
                GameConstant.VALUE_GAME_CHOISE,
                this.gameContinue,
                false,
                null,
                -1
        );
    }

    public void onButtonClick() {
        if (isBound) {
            clickSoundService.playClickSound(R.raw.button_click, 1.0f);
        }
    }
    private void initSoundService() {
        bindClickSoundService();
    }

    private void bindClickSoundService() {
        Intent intent2 = new Intent(this, ClickSound.class);
        bindService(intent2, serviceConnection, BIND_AUTO_CREATE);
    }

    @Override
    public void initAttibuts() {
        textLevel = findViewById(R.id.textLevel);
        choiseBeforeLevel = findViewById(R.id.choiseBeforeLevel);
        imageButton1 = findViewById(R.id.imageButton1);
        imageButton2 = findViewById(R.id.imageButton2);
        imageButton3 = findViewById(R.id.imageButton3);
        buttonContinueToLevel = findViewById(R.id.takeItem);
        currentLevel = intent.getIntExtra(GameConstant.KEY_LEVEL, 0);
        playerInstance = intent.getParcelableExtra(GameConstant.KEY_PLAYER);
        currentEnemieIndex = intent.getIntExtra(GameConstant.KEY_ENEMIE_INDEX, 0);
        levelStart = intent.getBooleanExtra(GameConstant.KEY_START_LEVEL, false);
        gameContinue = intent.getBooleanExtra(GameConstant.KEY_PLAYER_WIN, false);
        this.dataModel = intent.getParcelableExtra(GameConstant.KEY_DATA_MODEL);
    }

    @Override
    public void startActivityGameChoise() {
        //void
    }

    @Override
    public void startActivityGameNaration() {
        //void
    }

    @Override
    public void statActivityStory() {
        //void
    }

    @Override
    public void startActivityGame() {
        onButtonClick();
        this.intent = new Intent(this, GameActivity.class);
        this.intent.putExtra(GameConstant.KEY_LEVEL, this.currentLevel);
        this.intent.putExtra(GameConstant.KEY_PLAYER, this.playerInstance);
        this.intent.putExtra(GameConstant.KEY_PREVIOUS_ACTIVITY, GameConstant.VALUE_GAME_CHOISE);
        this.intent.putExtra(GameConstant.KEY_ENEMIE_INDEX, this.currentEnemieIndex);
        this.intent.putExtra(GameConstant.KEY_START_LEVEL, this.levelStart);
        this.intent.putExtra(GameConstant.KEY_PLAYER_WIN, this.gameContinue);
        this.intent.putExtra(GameConstant.KEY_DATA_MODEL, this.dataModel);
        startActivity(this.intent);
    }

    @Override
    public void startActivityPlayerChoise() {
        //void
    }

    private boolean addItemToPlayer() throws Exception {
        boolean result = true;
        Item item = getItem((JSONObject) selectedButton.getTag());
        if (playerInstance.isFullinventory()) return false;
        try {
            playerInstance.setInventory(item);
        } catch (Exception e) {
            e.printStackTrace();
        }
        return result;
    }

    private Item getItem(JSONObject itemJson) throws JSONException {
        return new Item(itemJson.getString("nom"), itemJson.getString("degat"), itemJson.getString("image"), itemJson.getString("description"));
    }

    @Override
    public void setListener() {
        imageButton1.setOnClickListener(view -> {
            onButtonClick();
            handleItemClick(view, imageButton1);
        });
        imageButton2.setOnClickListener(view -> {
            onButtonClick();
            handleItemClick(view, imageButton2);
        });
        imageButton3.setOnClickListener(view -> {
            onButtonClick();
            handleItemClick(view, imageButton3);
        });
        buttonContinueToLevel.setOnClickListener(view -> {
            onButtonClick();
            setContinueButon();
        });
        buttonContinueToLevel.setVisibility(View.INVISIBLE);
    }

    private void handleItemClick(View view, ImageButton button) {
        onClickButton((JSONObject) button.getTag());
        resetImageButtonSelection();
        selectedButton = button;
        button.setColorFilter(Color.argb(150, 0, 0, 0)); // Assombrir l'image
        setContinueButon();
    }

    private void setContinueButon() {
        buttonContinueToLevel.setVisibility(View.VISIBLE);
        buttonContinueToLevel.setOnClickListener(v -> {
            try {
                if (getItem((JSONObject) selectedButton.getTag()).getName().contains(GameConstant.CLEE_MAUDITE_FR) ||
                        getItem((JSONObject) selectedButton.getTag()).getName().contains(GameConstant.CLEE_MAUDITE_EN)) {
                    currentEnemieIndex = JsonReader.getIndexBoss(this, String.format(GameConstant.FORMAT_LEVEL, currentLevel));
                }
                else if (!addItemToPlayer()) {
                    this.playerInstance.setInentoryRandom(getItem((JSONObject) selectedButton.getTag()));
                }
            } catch (Exception e) {
                Log.d("error -> addItemPlayer", e.getMessage());
            }
            startActivityGame();
        });
    }

    @Override
    protected void onRestoreInstanceState(Bundle savedInstance) {
        try {
            super.onRestoreInstanceState(savedInstance);
            currentLevel = savedInstance.getInt(GameConstant.KEY_LEVEL);
            playerInstance = savedInstance.getParcelable(GameConstant.KEY_PLAYER);
            levelStart = savedInstance.getBoolean(GameConstant.KEY_START_LEVEL);
            gameContinue = savedInstance.getBoolean(GameConstant.KEY_PLAYER_WIN);
            currentEnemieIndex = savedInstance.getInt(GameConstant.KEY_ENEMIE_INDEX);
            dataModel = savedInstance.getParcelable(GameConstant.KEY_DATA_MODEL);
            int selectedButtonId= savedInstance.getInt("selectedButtonId", -1);
            String tagString = savedInstance.getString("selectedButtonTag", null);
            infoButton[0] = new JSONObject(savedInstance.getString("buttonTag0"));
            infoButton[1] = new JSONObject(savedInstance.getString("buttonTag1"));
            infoButton[2] = new JSONObject(savedInstance.getString("buttonTag2"));
            initItems();
            if (selectedButtonId != -1) {
                JSONObject tagObject = null;
                tagObject = new JSONObject(tagString);
                selectedButton = findViewById(selectedButtonId);
                selectedButton.setColorFilter(Color.argb(150, 0, 0, 0));
                onClickButton(tagObject);
                setContinueButon();
            }
            else{
                selectedButton = null;
            }
        }   catch (JSONException e) {
        throw new RuntimeException(e);
        } catch (Exception e) {
            throw new RuntimeException(e);
        }

    }

    @Override
    protected void onSaveInstanceState(Bundle outState) {
        super.onSaveInstanceState(outState);
        outState.putInt(GameConstant.KEY_LEVEL, this.currentLevel);
        outState.putParcelable(GameConstant.KEY_PLAYER, this.playerInstance);
        outState.putBoolean(GameConstant.KEY_START_LEVEL, this.levelStart);
        outState.putBoolean(GameConstant.KEY_PLAYER_WIN, this.gameContinue);
        outState.putInt(GameConstant.KEY_ENEMIE_INDEX, this.currentEnemieIndex);
        outState.putParcelable(GameConstant.KEY_DATA_MODEL, this.dataModel);
        outState.putString("buttonTag0", infoButton[0].toString());
        outState.putString("buttonTag1", infoButton[1].toString());
        outState.putString("buttonTag2", infoButton[2].toString());
        if (selectedButton != null) {
            outState.putInt("selectedButtonId", selectedButton.getId());
            JSONObject tagObject = (JSONObject) selectedButton.getTag();
            outState.putString("selectedButtonTag", tagObject.toString());

        }

    }

    private void showAlertDialog(TextView textView, String message) {
        textView.setText(message);
        textView.setTextColor(Color.RED);
    }

    private void initFrontWarning() throws Exception {
        if (playerInstance.isFullinventory()) {
            showAlertDialog(getTextViewWarning(), getString(R.string.errorInsertItem));
        }
    }

    private void initFront() throws Exception {
        initItems();
        initFrontWarning();
    }

    private void initItems() throws Exception {
        if(levelStart){
            if (infoButton[0] == null) {  // Supposons que si le premier est nul, tous le sont
                JSONArray objets = JsonReader.getItem(this, String.format(GameConstant.FORMAT_LEVEL, currentLevel));
                try {
                    if (objets != null && objets.length() > 0) {
                        JSONObject objet1 = objets.getJSONObject(0);
                        imageButton1.setImageResource(getResources().getIdentifier(objet1.getString("image"), "drawable", getPackageName()));
                        imageButton1.setTag(objet1);
                        infoButton[0] = objet1;  // Stockage du tag

                        JSONObject objet2 = objets.getJSONObject(1);
                        imageButton2.setImageResource(getResources().getIdentifier(objet2.getString("image"), "drawable", getPackageName()));
                        imageButton2.setTag(objet2);
                        infoButton[1] = objet2;  // Stockage du tag

                        JSONObject objet3 = objets.getJSONObject(2);
                        imageButton3.setImageResource(getResources().getIdentifier(objet3.getString("image"), "drawable", getPackageName()));
                        imageButton3.setTag(objet3);
                        infoButton[2] = objet3;  // Stockage du tag
                    }
                } catch (Exception e) {
                    e.printStackTrace();
                }
            } else {
                // Utilisation des tags stockés pour initialiser les boutons
                imageButton1.setImageResource(getResources().getIdentifier(infoButton[0].getString("image"), "drawable", getPackageName()));
                imageButton1.setTag(infoButton[0]);

                imageButton2.setImageResource(getResources().getIdentifier(infoButton[1].getString("image"), "drawable", getPackageName()));
                imageButton2.setTag(infoButton[1]);

                imageButton3.setImageResource(getResources().getIdentifier(infoButton[2].getString("image"), "drawable", getPackageName()));
                imageButton3.setTag(infoButton[2]);
            }

        }
        else {
            //modifier la textView (en disant vous avez vaincu etc)
            String[] drops = JsonReader.getDropOfEnemie(this, String.format(GameConstant.FORMAT_LEVEL, currentLevel), currentEnemieIndex -1);
            for (int i = 0; i < drops.length; i++) {
                String buttonID = String.format(GameConstant.FORMAT_BUTTON_CHOISE, i + 1);
                int resID = getResources().getIdentifier(buttonID, "id", getPackageName());
                ImageButton button = findViewById(resID);
                JSONObject object = JsonReader.getObject(this, drops[i]);
                button.setImageResource(getResources().getIdentifier(object.getString("image"), "drawable", getPackageName()));
                button.setTag(object);
                infoButton[i]=object;
            }
        }

    }

    private void onClickButton(JSONObject objet) {
        try {
            String objetName = objet.getString("nom");
            String objetDescription = objet.getString("description");

            // Créez le texte avec les labels et les valeurs
            String labelObjet = "Objet : ";
            String labelDescription = "Description : ";

            // Combinez le tout dans un SpannableString
            SpannableString spannable = new SpannableString(
                    labelObjet + objetName + "\n\n" +
                            labelDescription + objetDescription + "\n\n"
            );

            // Appliquez les styles aux labels
            int start = 0;
            int end = labelObjet.length();
            spannable.setSpan(new ForegroundColorSpan(Color.GREEN), start, end, Spannable.SPAN_EXCLUSIVE_EXCLUSIVE);
            spannable.setSpan(new StyleSpan(Typeface.BOLD), start, end, Spannable.SPAN_EXCLUSIVE_EXCLUSIVE);

            start = end + objetName.length() + 2;
            end = start + labelDescription.length();
            spannable.setSpan(new ForegroundColorSpan(Color.GREEN), start, end, Spannable.SPAN_EXCLUSIVE_EXCLUSIVE);
            spannable.setSpan(new StyleSpan(Typeface.BOLD), start, end, Spannable.SPAN_EXCLUSIVE_EXCLUSIVE);

            // Affichez le SpannableString dans le TextView
            textLevel.setText(spannable);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    private void resetImageButtonSelection() {
        imageButton1.setSelected(false);
        imageButton2.setSelected(false);
        imageButton3.setSelected(false);
        imageButton1.clearColorFilter();
        imageButton2.clearColorFilter();
        imageButton3.clearColorFilter();
    }

    private TextView getTextViewWarning() {
        return findViewById(R.id.textWarning);
    }
    @Override
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
