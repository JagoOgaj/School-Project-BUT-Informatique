package com.example.saes401.helper;

import android.content.Context;
import android.content.SharedPreferences;
import android.os.Parcel;
import android.os.Parcelable;
import android.preference.PreferenceManager;
import android.util.Base64;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;

import com.example.saes401.entities.Enemie;
import com.example.saes401.entities.Player;
import com.example.saes401.utilities.Inventory;

public class GameSave {
    private static final String PREFS_NAME = "game_save_prefs";
    private static boolean oneTime = true;

    public static void saveGame(
            @NonNull Context context,
            int level,
            Player playerInstance,
            int currentEnemyIndex,
            boolean levelStart,
            String previousActivity,
            boolean gameContinue,
            boolean endFight,
            Inventory enemieInventory,
            int enemieHP
    ) {
        if (oneTime){
            SharedPreferences sharedPreferences = PreferenceManager.getDefaultSharedPreferences(context);
            SharedPreferences.Editor editor = sharedPreferences.edit();

            // Vérifier si playerInstance est null
            if (playerInstance != null) {
                String playerSerialized = serializePlayer(playerInstance);
                editor.putString(GameConstant.KEY_PLAYER, playerSerialized);
            } else {
                // Si playerInstance est null, supprimer la clé correspondante
                editor.remove(GameConstant.KEY_PLAYER);
            }
            // Sauvegarder l'inventaire de l'ennemi
            if (enemieInventory != null) {
                String inventorySerialized = serializeInventory(enemieInventory);
                editor.putString(GameConstant.KEY_INVENTORY_ENEMIE, inventorySerialized);
            } else {
                editor.remove(GameConstant.KEY_INVENTORY_ENEMIE);
            }
            // Sauvegarder les points de vie de l'ennemi
            editor.putInt(GameConstant.KEY_HP_LEFT_ENEMIE, enemieHP);

            editor.putInt(GameConstant.KEY_LEVEL, level);
            editor.putInt(GameConstant.KEY_ENEMIE_INDEX, currentEnemyIndex);
            editor.putBoolean(GameConstant.KEY_START_LEVEL, levelStart);
            editor.putBoolean(GameConstant.KEY_PLAYER_WIN, gameContinue);
            editor.putString(GameConstant.KEY_PREVIOUS_ACTIVITY, previousActivity);
            editor.putBoolean(GameConstant.KEY_END_FIGHT, endFight);
            editor.apply();
        }
        oneTime = false;
    }

    @Nullable
    public static Player loadPlayer(@NonNull Context context) {
        SharedPreferences sharedPreferences = PreferenceManager.getDefaultSharedPreferences(context);
        String playerSerialized = sharedPreferences.getString(GameConstant.KEY_PLAYER, null);
        return deserializePlayer(playerSerialized);
    }

    public static int loadLevel(@NonNull Context context) {
        SharedPreferences sharedPreferences = PreferenceManager.getDefaultSharedPreferences(context);
        return sharedPreferences.getInt(GameConstant.KEY_LEVEL, 0); // 0 is the default value if not found
    }

    public static int loadCurrentEnemyIndex(@NonNull Context context) {
        SharedPreferences sharedPreferences = PreferenceManager.getDefaultSharedPreferences(context);
        return sharedPreferences.getInt(GameConstant.KEY_ENEMIE_INDEX, 0); // 0 is the default value if not found
    }

    public static boolean loadLevelStart(@NonNull Context context) {
        SharedPreferences sharedPreferences = PreferenceManager.getDefaultSharedPreferences(context);
        return sharedPreferences.getBoolean(GameConstant.KEY_START_LEVEL, false); // false is the default value if not found
    }

    public static String loadPreviousActivity(@NonNull Context context) {
        SharedPreferences sharedPreferences = PreferenceManager.getDefaultSharedPreferences(context);
        return sharedPreferences.getString(GameConstant.KEY_PREVIOUS_ACTIVITY, ""); // "" is the default value if not found
    }

    public static boolean loadPlayerWin(Context context) {
        SharedPreferences sharedPreferences = PreferenceManager.getDefaultSharedPreferences(context);
        return sharedPreferences.getBoolean(GameConstant.KEY_PLAYER_WIN, false);
    }

    @Nullable
    public static Inventory loadEnemieInventory(@NonNull Context context) {
        SharedPreferences sharedPreferences = PreferenceManager.getDefaultSharedPreferences(context);
        String inventorySerialized = sharedPreferences.getString(GameConstant.KEY_INVENTORY_ENEMIE, null);
        return deserializeInventory(inventorySerialized);
    }

    public static int loadEnemieHP(@NonNull Context context) {
        SharedPreferences sharedPreferences = PreferenceManager.getDefaultSharedPreferences(context);
        return sharedPreferences.getInt(GameConstant.KEY_HP_LEFT_ENEMIE, 0); // 0 is the default value if not found
    }

    public static boolean loadEndFight(@NonNull Context context) {
        SharedPreferences sharedPreferences = PreferenceManager.getDefaultSharedPreferences(context);
        return sharedPreferences.getBoolean(GameConstant.KEY_END_FIGHT, false); // false is the default value if not found
    }

    @Nullable
    private static String serializePlayer(Player player) {
        Parcel parcel = Parcel.obtain();
        player.writeToParcel(parcel, 0);
        byte[] bytes = parcel.marshall();
        parcel.recycle();
        return Base64.encodeToString(bytes, Base64.DEFAULT);
    }

    @Nullable
    private static String serializeInventory(Inventory inventory) {
        Parcel parcel = Parcel.obtain();
        inventory.writeToParcel(parcel, 0);
        byte[] bytes = parcel.marshall();
        parcel.recycle();
        return Base64.encodeToString(bytes, Base64.DEFAULT);
    }

    @Nullable
    private static Player deserializePlayer(String playerSerialized) {
        if (playerSerialized == null) {
            return null;
        }
        byte[] bytes = Base64.decode(playerSerialized, Base64.DEFAULT);
        Parcel parcel = Parcel.obtain();
        parcel.unmarshall(bytes, 0, bytes.length);
        parcel.setDataPosition(0);
        Player player = Player.CREATOR.createFromParcel(parcel);
        parcel.recycle();
        return player;
    }

    @Nullable
    private static Inventory deserializeInventory(String inventorySerialized) {
        if (inventorySerialized == null) {
            return null;
        }
        byte[] bytes = Base64.decode(inventorySerialized, Base64.DEFAULT);
        Parcel parcel = Parcel.obtain();
        parcel.unmarshall(bytes, 0, bytes.length);
        parcel.setDataPosition(0);
        Inventory inventory = Inventory.CREATOR.createFromParcel(parcel);
        parcel.recycle();
        return inventory;
    }

    public static void clearGameSaveKeys(@NonNull Context context) {
        SharedPreferences sharedPreferences = PreferenceManager.getDefaultSharedPreferences(context);
        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.remove(GameConstant.KEY_LEVEL);
        editor.remove(GameConstant.KEY_PLAYER);
        editor.remove(GameConstant.KEY_INVENTORY_ENEMIE);
        editor.remove(GameConstant.KEY_HP_LEFT_ENEMIE);
        editor.remove(GameConstant.KEY_ENEMIE_INDEX);
        editor.remove(GameConstant.KEY_START_LEVEL);
        editor.remove(GameConstant.KEY_PREVIOUS_ACTIVITY);
        editor.remove(GameConstant.KEY_END_FIGHT);
        editor.apply();
    }

    public static boolean isGameSaveExists(@NonNull Context context) {
        SharedPreferences sharedPreferences = PreferenceManager.getDefaultSharedPreferences(context);
        boolean levelExists = sharedPreferences.contains(GameConstant.KEY_LEVEL);
        boolean playerExists = sharedPreferences.contains(GameConstant.KEY_PLAYER);
        boolean inventoryExists = sharedPreferences.contains(GameConstant.KEY_INVENTORY_ENEMIE);
        boolean hpExists = sharedPreferences.contains(GameConstant.KEY_HP_LEFT_ENEMIE);
        boolean enemyIndexExists = sharedPreferences.contains(GameConstant.KEY_ENEMIE_INDEX);
        boolean startLevelExists = sharedPreferences.contains(GameConstant.KEY_START_LEVEL);
        boolean previousActivityExists = sharedPreferences.contains(GameConstant.KEY_PREVIOUS_ACTIVITY);
        boolean endFightExists = sharedPreferences.contains(GameConstant.KEY_END_FIGHT);
        return levelExists || playerExists || inventoryExists || hpExists || enemyIndexExists || startLevelExists || previousActivityExists || endFightExists;
    }
}
