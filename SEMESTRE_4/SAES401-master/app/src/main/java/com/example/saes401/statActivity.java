package com.example.saes401;

import android.content.ComponentName;
import android.content.Context;
import android.content.Intent;
import android.content.ServiceConnection;
import android.content.res.Configuration;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.graphics.Color;
import android.graphics.Typeface;
import android.os.Bundle;
import android.os.IBinder;
import android.text.SpannableString;
import android.text.Spanned;
import android.text.style.ForegroundColorSpan;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.ContextCompat;
import androidx.core.content.res.ResourcesCompat;

import com.example.saes401.db.DatabaseHelper;
import com.example.saes401.helper.GameConstant;
import com.example.saes401.helper.Settings;
import com.example.saes401.service.ClickSound;

import java.util.Locale;

public class statActivity extends AppCompatActivity {
    LinearLayout linearLayout;
    SQLiteDatabase db;
    DatabaseHelper db_helper;
    private int pageActuel = 0;
    private static final int nombreParPage = 3;
    TextView affichagePagination;
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
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_stat);
        initAttibuts();
        setListener();
        loadDataForpageActuel();
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

    public void initAttibuts() {
        linearLayout = findViewById(R.id.linear);
        db_helper = new DatabaseHelper(this);
        db = openOrCreateDatabase(db_helper.getDatabaseName(), MODE_PRIVATE, null);
        affichagePagination = findViewById(R.id.affichagePagination);
    }

    public void setListener() {
        findViewById(R.id.mainButton).setOnClickListener(view -> onClickMain());
        findViewById(R.id.deleteButton).setOnClickListener(view -> onClickDelete());
        findViewById(R.id.nextButton).setOnClickListener(view -> onClickNext());
        findViewById(R.id.prevButton).setOnClickListener(view -> onClickPrev());
    }

    private void onClickMain() {
        onButtonClick();
        Intent intent = new Intent(this, MainActivity.class);
        startActivity(intent);
    }
    private void onClickDelete() {
        onButtonClick();
        deleteAllRow();
    }
    private void onClickNext() {
        onButtonClick();
        int totalItemCount = getTotalItemCount();
        int maxPage = (totalItemCount + nombreParPage - 1) / nombreParPage - 1;
        if (pageActuel < maxPage) {
            pageActuel++;
            loadDataForpageActuel();
        }
    }
    private void onClickPrev() {
        onButtonClick();
        if (pageActuel > 0) {
            pageActuel--;
        }
        loadDataForpageActuel();
    }

    private int getTotalItemCount() {
        Cursor cursor = db.rawQuery(db_helper.getTotalCount(), null);
        cursor.moveToFirst();
        int count = cursor.getInt(0);
        cursor.close();
        return count;
    }

    private void deleteAllRow() {
        db.execSQL(db_helper.deleteAllRow());
    }


    private void loadDataForpageActuel() {
        Cursor cursor = db_helper.getDataByPage(nombreParPage, pageActuel * nombreParPage);
        linearLayout.removeAllViews();

        if (cursor.moveToFirst()) {
            do {
                // Récupérer les données de chaque ligne
                String score = cursor.getString(cursor.getColumnIndex("score"));
                String duration = cursor.getString(cursor.getColumnIndex("duration"));
                int maxDamageToPlayer = cursor.getInt(cursor.getColumnIndex("max_damage_to_player"));
                int maxDamageToEnemy = cursor.getInt(cursor.getColumnIndex("max_damage_to_enemy"));
                int heartLost = cursor.getInt(cursor.getColumnIndex("heart_lost"));
                boolean isWin = cursor.getInt(cursor.getColumnIndex("is_win")) > 0;

                // Créer une vue pour afficher ces données
                TextView textView = new TextView(this);
                textView.setBackground(ContextCompat.getDrawable(this, R.drawable.encadrementtextview)); // Appliquer le fond avec bordure
                setColoredKeywords(textView,score,duration,maxDamageToPlayer,maxDamageToEnemy,heartLost,isWin,this);
                if (getResources().getConfiguration().orientation == Configuration.ORIENTATION_LANDSCAPE) {
                    textView.setTextSize(9); // Taille plus petite en paysage
                } else {
                    textView.setTextSize(25); // Taille plus grande en portrait
                }
                // Ajouter la vue au LinearLayout
                linearLayout.addView(textView);
            } while (cursor.moveToNext());
        }
        cursor.close();
        int totalItemCount = getTotalItemCount();
        int totalPageCount = (totalItemCount + nombreParPage - 1) / nombreParPage;
        affichagePagination.setText("Page " + (pageActuel + 1) + " of " + totalPageCount);
    }


    public void setColoredKeywords(TextView textView, String score, String duration, int maxDamageToPlayer, int maxDamageToEnemy, int heartLost, boolean isWin, Context context) {

        String languageCode = Settings.loadLanguage(this);
        String format = languageCode.equals("fr") ? GameConstant.FORMAT_STAT_FR : GameConstant.FORMAT_STAT_EN;
        // Format du texte initial
        String result = isWin ? getString(R.string.win) : getString(R.string.lose);

        String fullText = String.format(format, score, duration, maxDamageToPlayer, maxDamageToEnemy, heartLost, result);

        // Création d'un SpannableString à partir du texte complet
        SpannableString spannableString = new SpannableString(fullText);

        // Définir la couleur
        int color = Color.parseColor("#A3E34C");

        // Appliquer le style aux mots clés
        String[] keywords =  {
                getString(R.string.score),
                getString(R.string.duration),
                getString(R.string.max_damage_to_player),
                getString(R.string.max_damage_to_enemy),
                getString(R.string.heart_lost),
                getString(R.string.winResult)
        };

        for (String keyword : keywords) {
            int start = spannableString.toString().indexOf(keyword);
            int end = start + keyword.length();
            if (start >= 0) {
                spannableString.setSpan(new ForegroundColorSpan(color), start, end, Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);
            }
        }
        Typeface typeface = ResourcesCompat.getFont(context, R.font.dpcomic);
        textView.setTypeface(typeface);

        // Mettre le texte formaté dans le TextView
        textView.setText(spannableString);
    }
    @Override
    protected void onSaveInstanceState(Bundle outState) {
        super.onSaveInstanceState(outState);
        outState.putInt(GameConstant.KEY_PAGINATION, pageActuel); // Sauvegarder la page actuelle
    }

    @Override
    protected void onRestoreInstanceState(Bundle savedInstanceState) {
        super.onRestoreInstanceState(savedInstanceState);
        pageActuel = savedInstanceState.getInt(GameConstant.KEY_PAGINATION, 0); // Restaurer la page actuelle
        loadDataForpageActuel(); // Recharger les données pour la page restaurée
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