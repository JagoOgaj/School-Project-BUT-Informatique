package com.example.saes401.db;

import android.content.ContentValues;
import android.database.sqlite.SQLiteDatabase;
import android.os.Build;
import android.os.Parcel;
import android.os.Parcelable;

import androidx.annotation.NonNull;

import com.example.saes401.helper.DataMethodsAnalytics;

import java.time.Duration;
import java.time.LocalDateTime;
import java.util.ArrayList;

public class DataModel implements DataMethodsAnalytics, Parcelable {
    private DatabaseHelper databaseHelper;
    private LocalDateTime start;
    private LocalDateTime end;
    private ArrayList<Integer> damageToPlayer;
    private ArrayList<Integer> damageToEnemy;
    private int heartLost;
    private String lastScore;
    private Boolean isWin;

    public DataModel() {
    }
    // Parcelable

    protected DataModel(Parcel in) {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
            start = (LocalDateTime) in.readSerializable();
        }
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
            end = (LocalDateTime) in.readSerializable();
        }
        damageToPlayer = in.readArrayList(Integer.class.getClassLoader());
        damageToEnemy = in.readArrayList(Integer.class.getClassLoader());
        heartLost = in.readInt();
        lastScore = in.readString();
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.Q) {
            isWin = in.readBoolean();
        }
    }

    public static final Creator<DataModel> CREATOR = new Creator<DataModel>() {
        @Override
        public DataModel createFromParcel(Parcel in) {
            return new DataModel(in);
        }

        @Override
        public DataModel[] newArray(int size) {
            return new DataModel[size];
        }
    };

    @Override
    public int describeContents() {
        return 0;
    }

    @Override
    public void writeToParcel(@NonNull Parcel dest, int flags) {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
            dest.writeSerializable(start);
        }
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
            dest.writeSerializable(end);
        }
        dest.writeList(damageToPlayer);
        dest.writeList(damageToEnemy);
        dest.writeInt(heartLost);
        dest.writeString(lastScore);
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.Q) {
            dest.writeBoolean(isWin != null ? isWin : false); // Ensure isWin is not null
        }
    }

    @Override
    public void addStart() {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
            start = LocalDateTime.now();
        }
    }

    @Override
    public void addEnd() {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
            end = LocalDateTime.now();
        }
    }

    @Override
    public String getTime() throws Exception {
        String result = "%d h, %d min, %d sec";
        if (end == null || start == null) throw new Exception("error -> start or end is null");
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
            Duration duration = Duration.between(start, end);
            long seconds = duration.getSeconds();
            long hours = seconds / 3600;
            long minutes = (seconds % 3600) / 60;
            long secs = seconds % 60;
            return String.format(result, hours, minutes, secs);
        }
        return result;
    }

    @Override
    public void addDamageToPlayer(int damage) {
        if (damageToPlayer == null) {
            damageToPlayer = new ArrayList<>();
        }
        damageToPlayer.add(damage);
    }

    @Override
    public int getMaxDamageToPlayer() {
        if (damageToPlayer != null && !damageToPlayer.isEmpty()) {
            return damageToPlayer.stream().max(Integer::compare).orElse(0);
        }
        return 0;
    }

    @Override
    public void addDamageToEnemy(int damage) {
        if (damageToEnemy == null) {
            damageToEnemy = new ArrayList<>();
        }
        damageToEnemy.add(damage);
    }

    @Override
    public int getMaxDamageToEnemy() {
        if (damageToEnemy != null && !damageToEnemy.isEmpty()) {
            return damageToEnemy.stream().max(Integer::compare).orElse(0);
        }
        return 0;
    }

    @Override
    public void addHeartLost(int heartLost) {
        this.heartLost += heartLost;
    }

    @Override
    public int getHeartLost() {
        return heartLost;
    }

    @Override
    public void addLastScore(String score) {
        this.lastScore = score;
    }

    @Override
    public String getLastScore() {
        return lastScore;
    }


    @Override
    public void addWin(boolean b) {
        this.isWin = b;
    }

    @Override
    public boolean getWin() {
        return isWin;
    }

    @Override
    public void putAllData() {
        if (start != null && end != null) {
            try {
                String time = getTime();
                ContentValues values = new ContentValues();
                values.put("duration", time);
                values.put("max_damage_to_player", getMaxDamageToPlayer());
                values.put("max_damage_to_enemy", getMaxDamageToEnemy());
                values.put("heart_lost", getHeartLost());
                values.put("score", getLastScore());
                values.put("is_win", getWin());

                SQLiteDatabase db = databaseHelper.getWritableDatabase();
                db.insert("playerGame", null, values);
                db.close();
            } catch (Exception e) {
                e.printStackTrace();
            }
        }
    }

    public void setDatabaseHelper(DatabaseHelper databaseHelper) {
        this.databaseHelper = databaseHelper;
    }
}
