package com.example.saes401.story;

import android.content.ComponentName;
import android.content.Context;
import android.content.Intent;
import android.content.ServiceConnection;
import android.graphics.Color;
import android.graphics.drawable.AnimationDrawable;
import android.os.Bundle;
import android.os.IBinder;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import com.example.saes401.GameActivity;
import com.example.saes401.R;
import com.example.saes401.db.DataModel;
import com.example.saes401.entities.Enemie;
import com.example.saes401.entities.Player;
import com.example.saes401.helper.GameConstant;
import com.example.saes401.helper.GameSave;
import com.example.saes401.helper.JsonReader;
import com.example.saes401.helper.Utilities;
import com.example.saes401.service.BackGroundFightSound;
import com.example.saes401.service.BackGroundSound;
import com.example.saes401.service.ClickSound;
import com.example.saes401.utilities.GameFight;
import com.example.saes401.utilities.Inventory;
import com.example.saes401.utilities.Item;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;
import java.util.Objects;
import java.util.Random;

public class Story extends AppCompatActivity implements Utilities, Runnable {
    private Intent intent;
    private int currentLevel;
    private Player playerInstance;
    private Enemie currentEnemieInstance;
    private int currentEnemieIndex;
    private GameFight fightInstance;
    private boolean gameContinue;
    private boolean levelStart;
    private Thread thread;
    private final Map<String, ImageView> heartMap = new HashMap<String, ImageView>();
    private final ArrayList<ImageView> imageViewsPLayer = new ArrayList<ImageView>();
    private final ArrayList<ImageView> imageViewsEnemie = new ArrayList<ImageView>();
    private int indexItemChoose = -1;
    private final Object lock = new Object();
    private boolean fightEnd = false;
    private DataModel dataModel;
    private Random random;
    private boolean isBound = false;
    private ClickSound clickSoundService;
    private int hpLeftEnemie = -1;
    private Inventory inventoryEnemieInstance;
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
        hideSystemUI();
        intent = getIntent();
        if (intent != null) {
            this.initAttibuts();
        }
        setContentView(R.layout.gameplay);
        try {
            initFront();
        } catch (Exception e) {
            throw new RuntimeException(e);
        }
        this.startStory();
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
        if (!gameContinue) {
            stopService(new Intent(this, BackGroundFightSound.class));
            startService(new Intent(this, BackGroundSound.class));
        } else {
            stopService(new Intent(this, BackGroundFightSound.class));
            startService(new Intent(this, BackGroundSound.class));
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
                GameConstant.VALUE_STORY,
                this.gameContinue,
                this.fightEnd,
                this.currentEnemieInstance.getInventory(),
                this.currentEnemieInstance.getHPEnemie()
        );
    }

    private void initSoundService() {
        stopService(new Intent(this, BackGroundSound.class));
        startService(new Intent(this, BackGroundFightSound.class));
        bindService(new Intent(this, ClickSound.class), serviceConnection, Context.BIND_AUTO_CREATE);
    }

    public void onClickButton() {
        if (isBound){
            clickSoundService.playClickSound(R.raw.button_click, 1.0f);
        }
    }

    @Override
    public void initAttibuts() {
        this.inventoryEnemieInstance = intent.getParcelableExtra(GameConstant.KEY_INVENTORY_ENEMIE);
        this.hpLeftEnemie = intent.getIntExtra(GameConstant.KEY_HP_LEFT_ENEMIE, -1);
        this.playerInstance = intent.getParcelableExtra(GameConstant.KEY_PLAYER);
        this.currentLevel = intent.getIntExtra(GameConstant.KEY_LEVEL, 0);
        this.currentEnemieIndex = intent.getIntExtra(GameConstant.KEY_ENEMIE_INDEX, 0);
        this.levelStart = intent.getBooleanExtra(GameConstant.KEY_START_LEVEL, false);
        this.gameContinue = intent.getBooleanExtra(GameConstant.KEY_PLAYER_WIN, false);
        this.dataModel = intent.getParcelableExtra(GameConstant.KEY_DATA_MODEL);
        this.fightEnd = intent.getBooleanExtra(GameConstant.KEY_END_FIGHT, false);
        if (currentEnemieInstance == null){
            try {
                initEnemie();
                addItemOfEnemie();
            } catch (Exception e) {
                e.printStackTrace();
            }
        }
    }

    private void initEnemie() throws Exception {
        int hp = this.hpLeftEnemie == -1 ? JsonReader.getEnemieHP(this, String.format(GameConstant.FORMAT_LEVEL, this.currentLevel), this.currentEnemieIndex) : this.hpLeftEnemie;
        String name = JsonReader.getEnemieName(this, String.format(GameConstant.FORMAT_LEVEL, this.currentLevel), this.currentEnemieIndex);
        Inventory inventory = this.inventoryEnemieInstance == null ? new Inventory(JsonReader.getItemsOfEnemie(this, String.format(GameConstant.FORMAT_LEVEL, this.currentLevel), this.currentEnemieIndex).length) : this.inventoryEnemieInstance;
        String damage = JsonReader.getEnemieDamageStringFormat(this, String.format(GameConstant.FORMAT_LEVEL, this.currentLevel), this.currentEnemieIndex);
        String image = JsonReader.getEnemieImageSrc(this, String.format(GameConstant.FORMAT_LEVEL, this.currentLevel), this.currentEnemieIndex);
        this.currentEnemieInstance = new Enemie(
                hp,
                name,
                this.currentLevel,
                this.currentEnemieIndex,
                inventory,
                damage,
                image
        );
    }

    private void addItemOfEnemie() throws Exception {
        String[] items = JsonReader.getItemsOfEnemie(this, String.format(GameConstant.FORMAT_LEVEL, this.currentLevel), this.currentEnemieIndex);
        for (String item : items) {
            this.currentEnemieInstance.getInventory().addItemsEnemie(new Item(
                    JsonReader.getObjectName(this, item),
                    JsonReader.getObjectDamage(this, item),
                    JsonReader.getImageObject(this, item),
                    JsonReader.getObjectDesc(this, item)
            ));
        }
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
        this.intent = new Intent(this, GameActivity.class);
        this.intent.putExtra(GameConstant.KEY_LEVEL, this.currentLevel);
        this.intent.putExtra(GameConstant.KEY_ENEMIE_INDEX, this.currentEnemieIndex);
        this.intent.putExtra(GameConstant.KEY_PLAYER, this.playerInstance);
        this.intent.putExtra(GameConstant.KEY_PREVIOUS_ACTIVITY, GameConstant.VALUE_STORY);
        this.intent.putExtra(GameConstant.KEY_PLAYER_WIN, this.gameContinue);
        this.intent.putExtra(GameConstant.KEY_START_LEVEL, this.levelStart);
        this.intent.putExtra(GameConstant.KEY_DATA_MODEL, this.dataModel);
        startActivity(intent);
    }

    @Override
    public void startActivityPlayerChoise() {

    }

    @Override
    public void setListener() {
        setListenerImageView();
    }


    @Override
    protected void onRestoreInstanceState(Bundle savedInstanceState) {
        super.onRestoreInstanceState(savedInstanceState);
        currentLevel = savedInstanceState.getInt(GameConstant.KEY_LEVEL);
        playerInstance = savedInstanceState.getParcelable(GameConstant.KEY_PLAYER);
        currentEnemieIndex = savedInstanceState.getInt(GameConstant.KEY_ENEMIE_INDEX);
        currentEnemieInstance = savedInstanceState.getParcelable(GameConstant.KEY_ENEMIE_INSTANCE);
        gameContinue = savedInstanceState.getBoolean(GameConstant.KEY_PLAYER_WIN);
        levelStart = savedInstanceState.getBoolean(GameConstant.KEY_START_LEVEL);
        dataModel = savedInstanceState.getParcelable(GameConstant.KEY_DATA_MODEL);
        startStory();
    }

    @Override
    protected void onSaveInstanceState(Bundle outState) {
        super.onSaveInstanceState(outState);
        outState.putInt(GameConstant.KEY_LEVEL, this.currentLevel);
        outState.putInt(GameConstant.KEY_ENEMIE_INDEX, this.currentEnemieIndex);
        outState.putParcelable(GameConstant.KEY_PLAYER, this.playerInstance);
        outState.putParcelable(GameConstant.KEY_ENEMIE_INSTANCE, this.currentEnemieInstance);
        outState.putBoolean(GameConstant.KEY_PLAYER_WIN, this.gameContinue);
        outState.putBoolean(GameConstant.KEY_START_LEVEL, this.levelStart);
        outState.putParcelable(GameConstant.KEY_DATA_MODEL, this.dataModel);
    }

    private void startStory() {
        thread = new Thread(this);
        thread.start();
    }

    private int getResultPlayer(@NonNull int[] dices, boolean useItem) {
        int resultPlayer = 0;
        int result = 0;
        for (int i = 0; i < dices.length; i++) {
            result += dices[i];
        }
        try {
            resultPlayer = fightInstance.getResultPlayer(result, useItem);
            indexItemChoose = -1;
        } catch (Exception e) {
            e.printStackTrace();
        }
        return resultPlayer;
    }

    private int getResultEnemie(int[] dices, Item itemEnemie) {
        int result = 0;
        try {
                for (int i = 0; i < dices.length; i++) {
                    result += (dices[i]);
                }
                result = fightInstance.getResultEnemie(result, itemEnemie);

        } catch (Exception ex) {
            throw new RuntimeException(ex);
        }
        return result;
    }

    @Override
    public void run() {
        this.fightInstance = new GameFight(playerInstance, currentEnemieInstance, this);
        while (!this.fightEnd) {
            runOnUiThread(() -> {
                setVisibilityButtonTake(true);
            });
            synchronized (lock) {
                try {
                    runOnUiThread(() -> {
                        int color = Color.parseColor("#B3FFFFFF");
                        getInformationTextView().setText(R.string.item);
                        getInformationTextView().setBackgroundColor(color);
                        getTextViewGamePLay().setBackgroundColor(Color.TRANSPARENT);
                    });
                    lock.wait();
                } catch (InterruptedException e) {
                    Log.d("error -> InitFront", Objects.requireNonNull(e.getMessage()));
                }
            }
            runOnUiThread(() -> {
                getInformationTextView().setText("");
                getInformationTextView().setBackgroundColor(Color.TRANSPARENT);

            });
            int[] dicesResultPlayer = new int[0];
            try {
                dicesResultPlayer = fightInstance.getDicePlayer();
            } catch (Exception e) {
                throw new RuntimeException(e);
            }
            int[] finalDicesResultPlayer = dicesResultPlayer;
            runOnUiThread(() -> animateDiceRoll(finalDicesResultPlayer, true, -1));
            waitForDelay();
            int resultPlayer = getResultPlayer(dicesResultPlayer, indexItemChoose != -1);
            int[] finalDicesResultPlayer1 = dicesResultPlayer;
            runOnUiThread(() -> {
                try {
                    initLinearItems(getViewChoiseLoot(), playerInstance.getInventory(), true);
                } catch (Exception e) {
                    throw new RuntimeException(e);
                }
            });
            runOnUiThread(() -> updateDiceResult(finalDicesResultPlayer1, resultPlayer, true));
            waitForDelay();
            int[] numberDicesEnemie = new int[0];
            random = new Random();
            boolean souldGetItem = random.nextBoolean();
            Item itemEnemie;
            try {
                if (souldGetItem && !currentEnemieInstance.getInventory().isEmptyInventory()) {
                    itemEnemie = currentEnemieInstance.getItem();
                } else {
                    itemEnemie = null;
                }
            } catch (Exception e) {
                throw new RuntimeException(e);
            }
            try {
                numberDicesEnemie = fightInstance.getDiceEnemie();
            } catch (Exception e) {
                throw new RuntimeException(e);
            }
            int[] finalNumberDicesEnemie1 = numberDicesEnemie;
            runOnUiThread(() -> animateDiceRoll(finalNumberDicesEnemie1, false, itemEnemie == null ? -1 : currentEnemieInstance.getInventory().getIndexOfItem(itemEnemie)));
            waitForDelay();
            int resultEnemie = 0;
            try {
                resultEnemie = getResultEnemie(numberDicesEnemie, itemEnemie);
            } catch (Exception e) {
                throw new RuntimeException(e);
            }
            int finalResultEnemie = resultEnemie;
            int[] finalNumberDicesEnemie = numberDicesEnemie;
            runOnUiThread(() -> {
                try {
                    initLinearItems(getLinearItemsEnemie(), currentEnemieInstance.getInventory(), false);
                } catch (Exception e) {
                    throw new RuntimeException(e);
                }
            });
            runOnUiThread(() -> updateDiceResult(finalNumberDicesEnemie, finalResultEnemie, false));
            waitForDelay();
            this.dataModel.addDamageToEnemy(resultPlayer);
            this.dataModel.addDamageToPlayer(resultEnemie);
            if (resultEnemie > resultPlayer) {
                playerInstance.setHP(playerInstance.getHPplayer() - 1);
                this.dataModel.addHeartLost(1);
                runOnUiThread(() -> setFrontHeart(GameConstant.FORMAT_HEART_PLAYER, playerInstance.getHPplayer(), true));
            } else if (resultPlayer > resultEnemie) {
                currentEnemieInstance.setHP(currentEnemieInstance.getHPEnemie() - 1);
                runOnUiThread(() -> setFrontHeart(GameConstant.FORMAT_HEART_ENEMIE, currentEnemieInstance.getHPEnemie(), true));
            } else {
                //egalité
                runOnUiThread(() ->  {
                    getTextViewGamePLay().setText(R.string.nullMatchFight);
                    getViewGameplay().removeAllViews();
                });
            }
            if (playerInstance.getHPplayer() == 0 || currentEnemieInstance.getHPEnemie() == 0) {
                runOnUiThread(() -> {
                    getViewGameplay().removeAllViews();
                    getTextViewGamePLay().setText("");
                    getTextScoreEnemie().setText("");
                    getTextScorePlayer().setText("");
                    getInformationTextView().setText("");
                    int text = playerInstance.getHPplayer() == 0 ? R.string.looseFight : R.string.winFight;
                    getTextViewGamePLay().setText(text);
                });
                waitForDelay();
                break;
            }
            else {
                runOnUiThread(() -> setListener());
            }
        }
        runOnUiThread(() -> {
            setListenerButtonTakeItem(true);
        });
        this.fightEnd = true;
        this.gameContinue = playerInstance.getHPplayer() > 0;
        synchronized (lock) {
            try {
                lock.wait();
            } catch (InterruptedException e) {
                Log.d("error -> InitFront", Objects.requireNonNull(e.getMessage()));
            }
        }
        startActivityGame();
    }

    private void initFront() throws Exception {
        int color = Color.parseColor("#B3FFFFFF");
        if (!this.gameContinue && fightEnd) {
            getViewGameplay().removeAllViews();
            getTextViewGamePLay().setText("");
            getTextScoreEnemie().setText("");
            getTextScorePlayer().setText("");
            getInformationTextView().setText("");
            setListenerButtonTakeItem(true);
            int text =R.string.looseFight ;
            getTextViewGamePLay().setText(text);
            getTextViewGamePLay().setBackgroundColor(color);
        }
        else if (this.gameContinue && fightEnd) {
            getViewGameplay().removeAllViews();
            getTextViewGamePLay().setText("");
            getTextScoreEnemie().setText("");
            getTextScorePlayer().setText("");
            getInformationTextView().setText("");
            setListenerButtonTakeItem(true);
            int text = R.string.winFight;
            getTextViewGamePLay().setText(text);
            getTextViewGamePLay().setBackgroundColor(color);

        }
        else {
            setTextGameplay(-1);
            setScoreText(getTextScoreEnemie(), 0);
            setScoreText(getTextScorePlayer(), 0);
            setCurrentLevelFront();
            setVisibilityButtonTake(true);
            getButtonTakeItem().setText(R.string.useDice);
            setListenerButtonTakeItem(false);
            getTextViewGamePLay().setBackgroundColor(color);
            initFrontPlayer();
            initFrontEnemie();
            setListener();
        }
    }

    private void setCurrentLevelFront() throws Exception {
        String text;
        if (this.currentEnemieIndex == JsonReader.getIndexBoss(this,String.format(GameConstant.FORMAT_LEVEL,currentLevel)) ){
            text="Boss";
        }
        else{
            text = String.format(
                    GameConstant.FORMAT_CURRENT_LEVEL,
                    this.currentLevel,
                    this.currentEnemieIndex + 1
            );
        }
        getCurrentLevelTextView().setText(text);

    }

    private void setTextGameplay(int result) {
        if (result == -1) getTextViewGamePLay().setText("");
        else getTextViewGamePLay().setText(String.valueOf(result));
    }

    private void setScoreText(@NonNull TextView textView, int result) {
        textView.setText(
                String.format(
                        GameConstant.FORMAT_SCORE,
                        result
                )
        );
    }

    private void setVisibilityButtonTake(boolean b) {
        if (b) getButtonTakeItem().setVisibility(View.VISIBLE);
        else getButtonTakeItem().setVisibility(View.INVISIBLE);
    }

    private void initFrontEnemie() throws Exception {
        initFrontHeart(getLinearHeartContainerEnemie(), currentEnemieInstance.getHPEnemie(), GameConstant.FORMAT_HEART_ENEMIE);
        initAvatar(getEnemieImageView(), getResources().getIdentifier(currentEnemieInstance.getImageSrc(), "drawable", getPackageName()), true);
        initNameEnemie(getTextViewEnemyName(), currentEnemieInstance.getName());
        initLinearItems(getLinearItemsEnemie(), currentEnemieInstance.getInventory(), false);
    }

    private void initFrontPlayer() throws Exception {
        initFrontHeart(getLinearHeartContainerPlayer(), playerInstance.getHPplayer(), GameConstant.FORMAT_HEART_PLAYER);
        initAvatar(getPlayerImageView(), getResources().getIdentifier(playerInstance.getImage(), "drawable", getPackageName()), false);
        initLinearItems(getViewChoiseLoot(), playerInstance.getInventory(), true);
    }

    private void initFrontHeart(@NonNull LinearLayout layout, int hp, String prefix) {
        layout.removeAllViews();
        for (int i = 0; i < hp; i++) {
            ImageView imageView = new ImageView(this);
            imageView.setImageResource(R.drawable.coueurtest);
            String id = String.format(prefix, i);
            imageView.setTag(id);
            LinearLayout.LayoutParams layoutParams = new LinearLayout.LayoutParams(
                    LinearLayout.LayoutParams.WRAP_CONTENT,
                    LinearLayout.LayoutParams.WRAP_CONTENT
            );
            imageView.setLayoutParams(layoutParams);
            layout.addView(imageView);
            heartMap.put(id, imageView);
        }
    }

    public void setVisibilityOfHeart(int index, String prefix) {
        try {
            heartMap.get(String.format(prefix, index)).setVisibility(ImageView.INVISIBLE);
        } catch (Exception e) {
            Log.d("error -> setVisibilityOfHeart", Objects.requireNonNull(e.getMessage()));
        }
    }

    public void setFrontHeart(String prefix, int index, boolean needSleep) {
        getViewGameplay().removeAllViews();
        getTextViewGamePLay().setText("");
        getTextScoreEnemie().setText("");
        getTextScorePlayer().setText("");
        if (needSleep) {
            try {
                setVisibilityOfHeart(index, prefix);
                Thread.sleep(2000);
            } catch (InterruptedException e) {
                throw new RuntimeException(e);
            }
        } else setVisibilityOfHeart(index, prefix);
    }

    private void initLinearItems(@NonNull LinearLayout layout, @NonNull Inventory inventory, boolean isPlayer) throws Exception {
        layout.removeAllViews();
        for (int i = 0; i < inventory.getCurentLength(); i++) {
            ImageView imageView = new ImageView(this);
            imageView.setImageResource(getResources().getIdentifier(inventory.getItem(i).getImage(), "drawable", getPackageName()));
            LinearLayout.LayoutParams layoutParams = new LinearLayout.LayoutParams(
                    GameConstant.WIDTH_HEIGHT_ITEMS, // Largeur en pixels
                    GameConstant.WIDTH_HEIGHT_ITEMS // Hauteur en pixels
            );
            layoutParams.setMargins(
                    GameConstant.MARGIN_ITEM,
                    GameConstant.MARGIN_ITEM,
                    GameConstant.MARGIN_ITEM,
                    GameConstant.MARGIN_ITEM
            );
            imageView.setLayoutParams(layoutParams);
            if (isPlayer) {
                imageView.setTag(inventory.getItem(i));
                imageViewsPLayer.add(imageView);
            } else imageViewsEnemie.add(imageView);
            layout.addView(imageView);
        }
    }

    private void waitForDelay() {
        synchronized (lock) {
            try {
                lock.wait(GameConstant.DELAY_TIME);
            } catch (InterruptedException e) {
                e.printStackTrace();
            }
        }
    }

    private void animateDiceRoll(int[] resultDices, boolean isPlayer, int itemEnemie) {
        getTextViewGamePLay().setText("");
        getViewGameplay().removeAllViews();
        getTextViewGamePLay().setBackgroundColor(Color.TRANSPARENT);
        if (!isPlayer && itemEnemie != -1) {
            int color = Color.parseColor("#B3FFFFFF");
            getTextViewGamePLay().setBackgroundColor(color);
            imageViewsEnemie.get(itemEnemie).setColorFilter(Color.argb(150, 0, 0, 0)); // Assombrir l'image
            getTextViewGamePLay().setText(currentEnemieInstance.getInventory().getItem(itemEnemie).getDesc());
        }
        for (int i = 0; i < resultDices.length; i++) {
            ImageView imageView = initImageView(R.drawable.animation_dice_test, true);
            AnimationDrawable anim = (AnimationDrawable) imageView.getBackground();
            getViewGameplay().addView(imageView);
            anim.start();
        }
    }

    private void updateDiceResult(@NonNull int[] dicesResult, int result, boolean isPlayer) {
        getTextViewGamePLay().setText("");
        getTextScoreEnemie().setText("");
        clearColorFilterImageView(imageViewsEnemie);
        int[] drawable = {
                R.drawable.dicetest1,
                R.drawable.dicetest2,
                R.drawable.dicetest3,
                R.drawable.dicetest4,
                R.drawable.dicetest5,
                R.drawable.dicetest6
        };
        getViewGameplay().removeAllViews();
        for (int i = 0; i < dicesResult.length; i++) {
            ImageView imageView = initImageView(drawable[dicesResult[i] - 1], false);
            getViewGameplay().addView(imageView);
        }
        int color = Color.parseColor("#B3FFFFFF");
        getTextViewGamePLay().setBackgroundColor(color);
        setTextGameplay(result);
        TextView textView = isPlayer ? getTextScorePlayer() : getTextScoreEnemie();
        setScoreText(textView, result);
    }

    @NonNull
    private ImageView initImageView(int res, boolean isAnimation) {
        ImageView imageView = new ImageView(this);
        if (isAnimation) imageView.setBackgroundResource(res);
        else imageView.setImageResource(res);
        LinearLayout.LayoutParams layoutParams = new LinearLayout.LayoutParams(
                GameConstant.WIDTH_HEIGHT_ITEMS, // Largeur en pixels
                GameConstant.WIDTH_HEIGHT_ITEMS // Hauteur en pixels
        );
        imageView.setLayoutParams(layoutParams);
        return imageView;
    }

    private void initNameEnemie(@NonNull TextView textView, String name) {
        textView.setText(name);
    }

    private void initAvatar(@NonNull ImageView imageView, int resID, boolean needRotation) {
        imageView.setImageResource(resID);
        if (needRotation) imageView.setScaleX(-1);
    }

    private ImageView getEnemieImageView() {
        return findViewById(R.id.enemieImage);
    }

    private LinearLayout getLinearItemsEnemie() {
        return findViewById(R.id.enemieItems);
    }

    private ImageView getPlayerImageView() {
        return findViewById(R.id.playerImage);
    }

    private LinearLayout getViewGameplay() {
        return findViewById(R.id.gameplay);
    }

    private TextView getTextViewGamePLay() {
        return findViewById(R.id.resultTextGamplay);
    }

    public final LinearLayout getViewChoiseLoot() {
        return findViewById(R.id.choiseLoot);
    }

    private LinearLayout getLinearHeartContainerEnemie() {
        return findViewById(R.id.heartContainer2);
    }

    private LinearLayout getLinearHeartContainerPlayer() {
        return findViewById(R.id.heartContainer1);
    }

    private TextView getTextScoreEnemie() {
        return findViewById(R.id.scoreEnemie);
    }

    private TextView getTextScorePlayer() {
        return findViewById(R.id.scorePlayer);
    }

    private TextView getTextViewEnemyName() {
        return findViewById(R.id.enemieName);
    }

    private Button getButtonTakeItem() {
        return findViewById(R.id.takeItem);
    }

    private TextView getCurrentLevelTextView() {
        return findViewById(R.id.currentLevel);
    }

    private TextView getInformationTextView() {
        return findViewById(R.id.infoTextView);
    }

    private void setListenerImageView() {
        for (ImageView imageView : imageViewsPLayer) {
            View.OnClickListener listener = new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    onClickButton();
                    Item item = (Item) imageView.getTag();
                    int selectedItemIndex = playerInstance.getInventory().getIndexOfItem(item);
                    if (indexItemChoose == selectedItemIndex) {
                        // Désélectionner l'item
                        imageView.clearColorFilter();
                        getTextViewGamePLay().setBackgroundColor(Color.TRANSPARENT);
                        setTextGameplay(-1);
                        getButtonTakeItem().setText(R.string.useDice); // Remettre le texte original
                        indexItemChoose = -1; // Réinitialiser l'index de l'item sélectionné
                    } else {
                        int color = Color.parseColor("#B3FFFFFF");
                        // Sélectionner l'item
                        clearColorFilterImageView(imageViewsPLayer);
                        indexItemChoose = selectedItemIndex;
                        imageView.setColorFilter(Color.argb(150, 0, 0, 0)); // Assombrir l'image
                        getTextViewGamePLay().setBackgroundColor(color);
                        getTextViewGamePLay().setText(item.getDesc());
                        getButtonTakeItem().setText(R.string.use);
                        setListenerButtonTakeItem(false);
                    }
                }
            };
            imageView.setOnClickListener(listener);
        }
    }


    private void removeClickListeners() {
        for (ImageView imageView : imageViewsPLayer) {
            imageView.setOnClickListener(null);
        }
    }

    private void clearColorFilterImageView(@NonNull ArrayList<ImageView> imageViews) {
        for (ImageView imageView : imageViews) {
            imageView.clearColorFilter();
        }
    }

    private void setListenerButtonTakeItem(boolean isEnd) {
        if (!isEnd) {
            getButtonTakeItem().setOnClickListener(view -> {
                onClickButton();
                removeClickListeners();
                setTextGameplay(-1);
                if (indexItemChoose != -1) {
                    playerInstance.setCurrentItem(indexItemChoose);
                }
                setVisibilityButtonTake(false);
                synchronized (lock) {
                    lock.notify();
                }
            });
        } else {
            getButtonTakeItem().setText(R.string.continue_game);
            getButtonTakeItem().setVisibility(View.VISIBLE);
            getButtonTakeItem().setOnClickListener(view -> {
                onClickButton();
                synchronized (lock) {
                    lock.notify();
                }
            });
        }
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
