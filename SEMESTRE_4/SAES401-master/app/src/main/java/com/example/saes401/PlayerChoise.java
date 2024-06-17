package com.example.saes401;

import android.content.ComponentName;
import android.content.Context;
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
import android.view.View;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.example.saes401.db.DataModel;
import com.example.saes401.entities.Player;
import com.example.saes401.helper.GameConstant;
import com.example.saes401.helper.GameSave;
import com.example.saes401.helper.JsonReader;
import com.example.saes401.helper.Utilities;
import com.example.saes401.service.ClickSound;

import org.json.JSONObject;

public class PlayerChoise extends AppCompatActivity implements Utilities {
    private Intent intent;
    private int currentLevel;
    private Player instancePLayer;
    private boolean isStartLevel;
    private boolean isPLayerWin;
    private DataModel dataModel;
    private ImageButton imageButton1;
    private ClickSound clickSoundService;
    private boolean isBound = false;
    private ImageButton imageButton2;
    private ImageButton imageButton3;
    private int selectedImageButton;
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
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_player_choise);
        intent = getIntent();
        try {
            imageButton1 = getImageView1();
            imageButton2 = getImageView2();
            imageButton3 = getImageView3();
            this.initFront();
            this.setListener();
        } catch (Exception e) {
            throw new RuntimeException(e);
        }
        hideSystemUI();
    }

    @Override
    protected void onStart() {
        super.onStart();
        initSoundService();
    }

    private void initSoundService() {
        bindClickSoundService();
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
                this.instancePLayer == null ? null : this.instancePLayer,
                0,
                this.isStartLevel,
                GameConstant.VALUE_PLAYER_CHOISE,
                this.isPLayerWin,
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
    private void bindClickSoundService() {
        Intent intent2 = new Intent(this, ClickSound.class);
        bindService(intent2, serviceConnection, Context.BIND_AUTO_CREATE);
    }
    private void initFront() throws Exception {
        getButtonContinue().setVisibility(View.INVISIBLE);
        if (JsonReader.getNumberPlayer(this) != 2) throw new Exception("length must be 2");
        else {
            imageButton1.setImageResource(
                    getResources().getIdentifier(
                            JsonReader.getImagePLayer(this, 0),
                            "drawable",
                            getPackageName()
                    )
            );
            imageButton2.setImageResource(
                    getResources().getIdentifier(
                            JsonReader.getImagePLayer(this, 1),
                            "drawable",
                            getPackageName()
                    )
            );
            imageButton3.setImageResource(
                    getResources().getIdentifier(
                            JsonReader.getImagePLayer(this, 2),
                            "drawable",
                            getPackageName()
                    )
            );
        }
    }

    @Override
    public void initAttibuts() throws Exception {
        currentLevel = 1;
        isStartLevel = true;
        isPLayerWin = true;
        dataModel = initDataModel();
        instancePLayer = new Player(
                JsonReader.getHP_Player(this, selectedImageButton),
                JsonReader.getDamagePlayer(this, selectedImageButton),
                JsonReader.getImagePLayer(this, selectedImageButton),
                JsonReader.getNamePlayer(this, selectedImageButton)
        );
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
        this.intent.putExtra(GameConstant.KEY_PREVIOUS_ACTIVITY, GameConstant.VALUE_PLAYER_CHOISE);
        this.intent.putExtra(GameConstant.KEY_PLAYER_WIN, this.isPLayerWin);
        this.intent.putExtra(GameConstant.KEY_ENEMIE_INDEX, 0);
        this.intent.putExtra(GameConstant.KEY_START_LEVEL, this.isStartLevel);
        this.intent.putExtra(GameConstant.KEY_PLAYER, this.instancePLayer);
        this.intent.putExtra(GameConstant.KEY_DATA_MODEL, this.dataModel);
        startActivity(this.intent);
    }

    @Override
    public void startActivityPlayerChoise() {

    }

    @Override
    public void setListener() {
        imageButton1.setOnClickListener(v -> {
            onButtonClick();
            onClickButton(0);
            resetImageButtonSelection();
            imageButton1.setColorFilter(Color.argb(150, 0, 0, 0)); // Assombrir l'image
            selectedImageButton = 0;
            setContinueButton();
        });
        imageButton2.setOnClickListener(v -> {
            onButtonClick();
            onClickButton(1);
            resetImageButtonSelection();
            imageButton2.setColorFilter(Color.argb(150, 0, 0, 0)); // Assombrir l'image
            selectedImageButton = 1;
            setContinueButton();
        });
        imageButton3.setOnClickListener(v -> {
            onButtonClick();
            onClickButton(2);
            resetImageButtonSelection();
            imageButton3.setColorFilter(Color.argb(150, 0, 0, 0)); // Assombrir l'image
            selectedImageButton = 2;
            setContinueButton();
        });
    }

    private DataModel initDataModel() {
        //don't insert in database
        DataModel dataModel = new DataModel();
        dataModel.addStart();
        return dataModel;
    }

    private void onClickButton(int index) {
        try {
            String objetName = JsonReader.getNamePlayer(this, index);
            String objetDescription = JsonReader.getDamagePlayer(this, index);
            int objetPv = JsonReader.getHP_Player(this, index);

            // Créez le texte avec les labels et les valeurs
            String labelObjet = "Nom : ";
            String labelDescription = "Dégats : ";
            String labelPv = "Pv :";

            // Combinez le tout dans un SpannableString
            SpannableString spannable = new SpannableString(
                    labelObjet + objetName + "\n\n" +
                            labelDescription + objetDescription + "\n\n" +
                            labelPv + String.valueOf(objetPv) + "\n\n"
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

            start =end + objetDescription.length() + 2;
            end =start + labelPv.length();
            spannable.setSpan(new ForegroundColorSpan(Color.GREEN), start, end, Spannable.SPAN_EXCLUSIVE_EXCLUSIVE);
            spannable.setSpan(new StyleSpan(Typeface.BOLD), start, end, Spannable.SPAN_EXCLUSIVE_EXCLUSIVE);

            // Affichez le SpannableString dans le TextView
            getTextLevel().setText(spannable);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    private TextView getTextLevel() {
        return findViewById(R.id.textLevel);
    }

    private ImageButton getImageView1() {
        return findViewById(R.id.imageButton1);
    }

    private ImageButton getImageView2() {
        return findViewById(R.id.imageButton2);
    }

    private ImageButton getImageView3() {
        return findViewById(R.id.imageButton3);
    }

    private Button getButtonContinue() {
        return findViewById(R.id.takeItem);
    }

    private void resetImageButtonSelection() {
        imageButton1.setSelected(false);
        imageButton2.setSelected(false);
        imageButton3.setSelected(false);
        imageButton1.clearColorFilter();
        imageButton2.clearColorFilter();
        imageButton3.clearColorFilter();
    }

    private void setContinueButton() {
        getButtonContinue().setVisibility(View.VISIBLE);
        getButtonContinue().setOnClickListener(v -> {
            try {
                this.initAttibuts();
            } catch (Exception e) {
                throw new RuntimeException(e);
            }
            startActivityGame();
        });
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