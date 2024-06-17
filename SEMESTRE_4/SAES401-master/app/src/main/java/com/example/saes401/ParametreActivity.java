package com.example.saes401;

import android.content.ComponentName;
import android.content.Context;
import android.content.Intent;
import android.content.ServiceConnection;
import android.media.AudioManager;
import android.os.Bundle;
import android.os.IBinder;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.SeekBar;
import android.widget.Spinner;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.example.saes401.helper.GameConstant;
import com.example.saes401.helper.Settings;
import com.example.saes401.service.BackGroundSound;
import com.example.saes401.service.ClickSound;

import java.util.Locale;
import java.util.Objects;

public class ParametreActivity extends AppCompatActivity {
    private SeekBar volumeSeekBar;
    private Spinner langueSpinner;
    private Button sauvegardeButton, mainButton;
    String selectedLanguage;
    int volume;
    private AudioManager audioManager;
    private boolean isBound = false;
    private ClickSound clickSoundService;
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
        setContentView(R.layout.activity_parametre);

        volumeSeekBar = findViewById(R.id.volumeSeekBar);
        langueSpinner = findViewById(R.id.languespinner);
        sauvegardeButton = findViewById(R.id.sauvegardeButton);
        mainButton = findViewById(R.id.mainButton);

        audioManager = (AudioManager) getSystemService(Context.AUDIO_SERVICE);
        setupSpinner();
        setupSeekBar();
        setupButtons();
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

    public void onButtonClick() {
        if (isBound) {
            clickSoundService.playClickSound(R.raw.button_click, 1.0f);
        }
    }

    private void bindClickSoundService() {
        Intent intent2 = new Intent(this, ClickSound.class);
        bindService(intent2, serviceConnection, Context.BIND_AUTO_CREATE);
    }

    private void setupSpinner() {
        onButtonClick();
        ArrayAdapter<CharSequence> adapter = ArrayAdapter.createFromResource(this,
                R.array.langues_array, R.layout.spinner_vert);
        adapter.setDropDownViewResource(R.layout.spinner_vert);
        langueSpinner.setAdapter(adapter);
        String langueParDefaut = Settings.loadLanguage(this);
        chargementParDefaut(langueParDefaut);
        langueSpinner.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                onButtonClick();
                selectedLanguage = parent.getItemAtPosition(position).toString();
                if (Objects.equals(selectedLanguage, "French") || Objects.equals(selectedLanguage, "Français")) {
                    selectedLanguage = "fr";
                } else if (Objects.equals(selectedLanguage, "English") || Objects.equals(selectedLanguage, "Anglais")) {
                    selectedLanguage = "en";
                }
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {
                // Aucun code nécessaire ici
            }
        });
    }

    private void setupSeekBar() {
        int maxVolume = audioManager.getStreamMaxVolume(AudioManager.STREAM_MUSIC);
        volumeSeekBar.setMax(maxVolume);

        // Initialise le volume avec la valeur sauvegardée
        int volumeSave = audioManager.getStreamVolume(AudioManager.STREAM_MUSIC);
        volumeSeekBar.setProgress(volumeSave);
        audioManager.setStreamVolume(AudioManager.STREAM_MUSIC, volumeSave, 0);

        // Assigner la valeur initiale du volume
        volume = volumeSave;

        volumeSeekBar.setOnSeekBarChangeListener(new SeekBar.OnSeekBarChangeListener() {
            @Override
            public void onProgressChanged(SeekBar seekBar, int progress, boolean fromUser) {
                if (fromUser) {  // Vérifie si le changement vient de l'utilisateur
                    audioManager.setStreamVolume(AudioManager.STREAM_MUSIC, progress, AudioManager.FLAG_SHOW_UI);

                }
            }

            @Override
            public void onStartTrackingTouch(SeekBar seekBar) {
                // Optionnel, appelé lorsque l'utilisateur commence à toucher le SeekBar
            }

            @Override
            public void onStopTrackingTouch(SeekBar seekBar) {
                // Optionnel, appelé après que l'utilisateur ait relâché le SeekBar
            }
        });
    }

    private void setupButtons() {
        sauvegardeButton.setOnClickListener(v -> {
            onButtonClick();
            Settings.saveLanguage(this, selectedLanguage);
            restartBackgroundSoundService();

            String message = "Saved parameters";
            if (selectedLanguage.equals("fr")) {
                message = "Paramètres sauvegardés";
            }

            Toast.makeText(ParametreActivity.this, message, Toast.LENGTH_SHORT).show();
            Intent intent = new Intent(this, MainActivity.class);
            startActivity(intent);
        });

        mainButton.setOnClickListener(v -> {
            onButtonClick();
            // Code pour retourner au menu principal
            Intent intent = new Intent(this, MainActivity.class);
            startActivity(intent);
            audioManager.setStreamVolume(AudioManager.STREAM_MUSIC, volume, AudioManager.FLAG_SHOW_UI);
        });
    }

    private void restartBackgroundSoundService() {
        // Arrêter le service s'il est en cours d'exécution
        stopService(new Intent(this, BackGroundSound.class));

        // Redémarrer le service avec le nouveau volume
        Intent intent = new Intent(this, BackGroundSound.class);
        float volumePercentage = volume / (float) audioManager.getStreamMaxVolume(AudioManager.STREAM_MUSIC);
        intent.putExtra(GameConstant.VOLUME, volumePercentage);
        startService(intent);
    }

    private void chargementParDefaut(String langue) {
        ArrayAdapter<CharSequence> adapter = (ArrayAdapter<CharSequence>) langueSpinner.getAdapter();
        int spinnerPosition = adapter.getPosition(isoVersLangue(langue));
        langueSpinner.setSelection(spinnerPosition);
    }

    private String isoVersLangue(String langue) {
        Locale locale = new Locale(langue);
        return locale.getDisplayName(locale);
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
