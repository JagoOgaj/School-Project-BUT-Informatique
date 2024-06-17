package com.example.saes401;

import android.content.ComponentName;
import android.content.Context;
import android.content.Intent;
import android.content.ServiceConnection;
import android.media.MediaPlayer;
import android.os.Bundle;
import android.os.IBinder;
import android.view.View;
import android.view.animation.Animation;
import android.view.animation.TranslateAnimation;
import android.widget.Button;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

import com.example.saes401.helper.GameConstant;
import com.example.saes401.service.BackGroundSound;
import com.example.saes401.service.ClickSound;

public class CreditsActivity extends AppCompatActivity {
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
        setContentView(R.layout.activity_credit);

        TextView creditsText = findViewById(R.id.creditsText);
        Button mainButton = findViewById(R.id.mainButton);

        TranslateAnimation animation = new TranslateAnimation(
                Animation.RELATIVE_TO_PARENT, 0f,
                Animation.RELATIVE_TO_PARENT, 0f,
                Animation.RELATIVE_TO_PARENT, 1f,
                Animation.RELATIVE_TO_PARENT, 0f);
        animation.setDuration(15000);

        mainButton.setOnClickListener(v -> {
            onButtonClick();
            Intent intent = new Intent(this, MainActivity.class);
            startActivity(intent);
        });
        animation.setAnimationListener(new Animation.AnimationListener() {
            @Override
            public void onAnimationStart(Animation animation) {
                // Action à réaliser lorsque l'animation commence
            }

            @Override
            public void onAnimationEnd(Animation animation) {
                // Rendre le bouton visible à la fin de l'animation
                mainButton.setVisibility(View.VISIBLE);
            }

            @Override
            public void onAnimationRepeat(Animation animation) {
                // Action à réaliser à chaque répétition de l'animation
            }
        });

        // Démarrer l'animation
        creditsText.startAnimation(animation);
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

    private void initSoundService() {
        bindClickSoundService();
    }

    private void bindClickSoundService() {
        Intent intent2 = new Intent(this, ClickSound.class);
        bindService(intent2, serviceConnection, Context.BIND_AUTO_CREATE);
    }

    public void onButtonClick() {
        if (isBound) {
            clickSoundService.playClickSound(R.raw.button_click, 1.0f);
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
