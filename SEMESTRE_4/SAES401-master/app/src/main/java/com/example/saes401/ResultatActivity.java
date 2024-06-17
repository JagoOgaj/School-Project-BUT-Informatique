package com.example.saes401;

import android.content.ComponentName;
import android.content.Context;
import android.content.Intent;
import android.content.ServiceConnection;
import android.graphics.Color;
import android.os.Bundle;
import android.os.IBinder;
import android.view.View;
import android.widget.TextView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.example.saes401.helper.GameConstant;
import com.example.saes401.helper.Utilities;
import com.example.saes401.service.BackGroundSound;
import com.example.saes401.service.ClickSound;

import org.json.JSONException;
import org.json.JSONObject;

public class ResultatActivity extends AppCompatActivity implements Utilities {
    protected TextView resultatText;
    private boolean resultat;
    private Intent intent;
    private ClickSound clickSoundService;
    private boolean isBound = false;

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
        intent = getIntent();
        if(intent != null){
            try {
                initAttibuts();
            } catch (Exception e) {
                throw new RuntimeException(e);
            }
        }
        setContentView(R.layout.activity_resultat);
        setListener();
        affichageResultat();
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
        bindClickSoundService();
    }

    private void bindClickSoundService() {
        Intent intent2 = new Intent(this, ClickSound.class);
        bindService(intent2, serviceConnection, Context.BIND_AUTO_CREATE);
    }

    @Override
    public void initAttibuts() throws Exception {
        this.resultat = intent.getBooleanExtra(GameConstant.KEY_PLAYER_WIN,false);
    }

    @Override
    public void startActivityGameChoise() {

    }

    @Override
    public void startActivityGameNaration() {

    }

    @Override
    public void statActivityStory() {

    }

    @Override
    public void startActivityGame() {

    }

    @Override
    public void startActivityPlayerChoise() {

    }

    public void setListener() {
        findViewById(R.id.continuButton).setOnClickListener(view -> onClickContinue());
        resultatText = findViewById(R.id.resultatText);

    }
    private void onClickContinue() {
        onButtonClick();
        Intent intent = new Intent(this, CreditsActivity.class);
        startActivity(intent);
    }
    @Override
    protected void onSaveInstanceState(Bundle outState) {
        super.onSaveInstanceState(outState);

    }
    @Override
    protected void onRestoreInstanceState(Bundle savedInstance) {
            super.onRestoreInstanceState(savedInstance);

    }
    private void affichageResultat(){
        if(this.resultat){
            resultatText.setText(R.string.win);
        }
        else{
            resultatText.setText(R.string.lose);

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