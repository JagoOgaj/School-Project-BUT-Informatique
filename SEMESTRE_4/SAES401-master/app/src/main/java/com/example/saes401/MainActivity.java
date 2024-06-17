package com.example.saes401;

import android.content.ComponentName;
import android.content.Context;
import android.content.Intent;
import android.content.ServiceConnection;
import android.media.AudioManager;
import android.os.Bundle;
import android.os.IBinder;
import android.view.View;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;

import com.example.saes401.helper.GameConstant;
import com.example.saes401.helper.GameSave;
import com.example.saes401.helper.Settings;
import com.example.saes401.helper.Utilities;
import com.example.saes401.service.BackGroundSound;
import com.example.saes401.service.ClickSound;

public class MainActivity extends AppCompatActivity implements Utilities {
    private Intent intent;
    private ClickSound clickSoundService;
    private boolean isBound = false;

    private boolean test;
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
        loadParametre();
        setContentView(R.layout.activity_main);
        this.setListener();
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

    public void onButtonClick() {
        if (isBound) {
            clickSoundService.playClickSound(R.raw.button_click, 1.0f);
        }
    }

    private void initSoundService() {
        bindBackGroundSoundService();
        bindClickSoundService();
    }

    private void bindClickSoundService() {
        Intent intent2 = new Intent(this, ClickSound.class);
        bindService(intent2, serviceConnection, Context.BIND_AUTO_CREATE);
    }

    private void bindBackGroundSoundService() {
        Intent intent1 = new Intent(this, BackGroundSound.class);
        intent1.putExtra(GameConstant.VOLUME, 1.0f);
        startService(intent1);
    }

    private void onClickCredits() {
        onButtonClick();
        startCredit();

    }

    private void onClickStart() {
        onButtonClick();
        startActivityPlayerChoise();
    }

    private void onClickContinue() {
        onButtonClick();
        if (GameSave.isGameSaveExists(this)){
            startActivityGame();
        }
        else {
            Toast.makeText(this, R.string.errorGameContinue, Toast.LENGTH_SHORT).show();
        }
    }

    private void onClickSettings() {
        onButtonClick();
        startParametre();
    }

    private void onClickStat() {
        onButtonClick();
        startStat();
    }

    @Override
    public void initAttibuts() {
        //void
    }

    @Override
    public void startActivityGameChoise() {
        // Not used
    }

    @Override
    public void startActivityGameNaration() {
        // Not used
    }

    @Override
    public void statActivityStory() {
        // Not used
    }

    @Override
    public void startActivityGame() {
        Intent intent = new Intent(this, GameActivity.class);
        intent.putExtra(GameConstant.KEY_PREVIOUS_ACTIVITY, GameConstant.VALUE_GAME_CONTINUE);
        startActivity(intent);
    }

    @Override
    public void startActivityPlayerChoise() {
        intent = new Intent(this, PlayerChoise.class);
        startActivity(intent);
    }

    public void startParametre() {
        intent = new Intent(this, ParametreActivity.class);
        startActivity(intent);
    }

    public void startStat() {
        intent = new Intent(this, statActivity.class);
        startActivity(intent);
    }

    public void startCredit() {
        intent = new Intent(this, CreditsActivity.class);
        startActivity(intent);
    }

    @Override
    public void setListener() {
        findViewById(R.id.creditsButton).setOnClickListener(view -> onClickCredits());
        findViewById(R.id.startButton).setOnClickListener(view -> onClickStart());
        findViewById(R.id.continueButton).setOnClickListener(view -> onClickContinue());
        findViewById(R.id.parametreButton).setOnClickListener(view -> onClickSettings());
        findViewById(R.id.statButton).setOnClickListener(view -> onClickStat());
    }

    private void loadParametre() {
        // Charger la langue
        String language = Settings.loadLanguage(this);
        Settings.changeLanguage(MainActivity.this, language);
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
