package com.example.saes401.service;

import android.app.Service;
import android.content.Intent;
import android.media.MediaPlayer;
import android.os.IBinder;

import androidx.annotation.Nullable;

import com.example.saes401.R;
import com.example.saes401.helper.GameConstant;

public class BackGroundFightSound extends Service {

    private MediaPlayer mediaPlayer;

    @Override
    public void onCreate() {
        super.onCreate();
        mediaPlayer = MediaPlayer.create(this, R.raw.witcher);
        mediaPlayer.setLooping(true);
        mediaPlayer.start();
    }

    @Override
    public void onDestroy() {
        if (mediaPlayer != null) {
            mediaPlayer.stop();
            mediaPlayer.release();
        }
        super.onDestroy();
    }

    @Override
    public int onStartCommand(Intent intent, int flags, int startId) {
        if (intent != null && intent.hasExtra(GameConstant.VOLUME)) {
            float volume = intent.getFloatExtra(GameConstant.VOLUME, 1.0f); // Par défaut, 1.0f
            playBackgroundSound(volume);
        } else {
            playBackgroundSound(1.0f); // Volume par défaut si aucune valeur n'est fournie
        }
        return START_STICKY;
    }

    private void playBackgroundSound(float volume) {
        if (mediaPlayer != null) {
            mediaPlayer.setVolume(volume, volume);
            mediaPlayer.start();
        }
    }
    @Nullable
    @Override
    public IBinder onBind(Intent intent) {
        return null;
    }
}
