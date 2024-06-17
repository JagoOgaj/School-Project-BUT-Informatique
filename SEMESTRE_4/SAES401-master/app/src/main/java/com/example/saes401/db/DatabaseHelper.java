package com.example.saes401.db;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

import java.util.Random;

public class DatabaseHelper extends SQLiteOpenHelper {
    private static final String DATABASE_NAME = "gameDataBase.db";
    private static final int DATABASE_VERSION = 1;
    private static final String TABLE_NAME = "playerGame";
    private static final String COLUMN_ID = "id";
    private static final String COLUMN_SCORE = "score";
    private static final String COLUMN_DURATION = "duration";
    private static final String COLUMN_MAX_DAMAGE_TO_PLAYER = "max_damage_to_player";
    private static final String COLUMN_MAX_DAMAGE_TO_ENEMY = "max_damage_to_enemy";
    private static final String COLUMN_HEART_LOST = "heart_lost";
    private static final String COLUMN_IS_WIN = "is_win";
    private static final String CREATE_TABLE_PLAYER_DATA =
            "CREATE TABLE " + TABLE_NAME + " (" +
                    COLUMN_ID + " INTEGER PRIMARY KEY AUTOINCREMENT, " +
                    COLUMN_SCORE + " TEXT, " +
                    COLUMN_DURATION + " INTEGER, " +
                    COLUMN_MAX_DAMAGE_TO_PLAYER + " INTEGER, " +
                    COLUMN_MAX_DAMAGE_TO_ENEMY + " INTEGER, " +
                    COLUMN_HEART_LOST + " INTEGER, " +
                    COLUMN_IS_WIN + " INTEGER " + // Nouvelle colonne
                    ");";

    public DatabaseHelper(Context context) {
        super(context, DATABASE_NAME, null, DATABASE_VERSION);
    }

    @Override
    public void onCreate(SQLiteDatabase db) {
        db.execSQL(CREATE_TABLE_PLAYER_DATA);
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_NAME);
        onCreate(db);
    }

    public String getDatabaseName() {
        return DATABASE_NAME;
    }

    public String getTotalCount() {

        return "SELECT COUNT(*) FROM " + TABLE_NAME + ";";
    }
    public String deleteAllRow() {

        return "DELETE FROM " + TABLE_NAME + ";";
    }

    public Cursor getDataByPage(int limit, int offset) {
        SQLiteDatabase db = this.getReadableDatabase();
        String query = "SELECT * FROM " + TABLE_NAME + " LIMIT ? OFFSET ?";
        return db.rawQuery(query, new String[]{String.valueOf(limit), String.valueOf(offset)});
    }



    //todo faire les méthodes de récupérations des données
}
