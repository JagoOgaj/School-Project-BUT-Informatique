package com.example.saes401.helper;

import android.content.Context;
import android.content.res.Resources;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.InputStream;
import java.util.ArrayList;
import java.util.Collections;
import java.util.List;
import java.util.Scanner;

public class JsonReader {

    public static int getNumberPlayer(Context context) {
        int length = -1;
        try {
            String json = loadJsonFromRaw(context.getResources(), GameConstant.PLAYERS_JSON, context.getPackageName());
            JSONObject jsonObject = new JSONObject(json);
            length = jsonObject.getJSONArray("players").length() - 1;
        } catch (Exception e) {
            e.printStackTrace();
        }
        return length;
    }

    private static JSONObject getPlayerAtIndex(Context context, int index) {
        JSONObject playerObjectJson = null;
        try {
            String json = loadJsonFromRaw(context.getResources(), GameConstant.PLAYERS_JSON, context.getPackageName());
            JSONObject jsonObject = new JSONObject(json);
            JSONArray players = jsonObject.getJSONArray("players");

            // Vérifiez si l'indice est valide
            if (index >= 0 && index < players.length()) {
                playerObjectJson = players.getJSONObject(index);
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
        return playerObjectJson;
    }

    public static String getImagePLayer(Context context, int index) throws Exception {
        String imageSrc = JsonReader.getPlayerAtIndex(context, index).getString("image_sansfond");
        if (imageSrc == null) throw new Exception("null image");
        else return imageSrc;
    }

    public static String getNamePlayer(Context context, int index) throws Exception {
        String name = JsonReader.getPlayerAtIndex(context, index).getString("name");
        if (name == null) throw new Exception("null name");
        else return name;
    }

    public static String getDamagePlayer(Context context, int index) throws Exception {
        String damage = JsonReader.getPlayerAtIndex(context, index).getString("damage");
        if (damage == null) throw new Exception("null damage");
        else return damage;
    }

    public static int getHP_Player(Context context, int index) throws Exception {
        int hp = JsonReader.getPlayerAtIndex(context, index) == null ||
                !(JsonReader.getPlayerAtIndex(context, index).has("healPoint")) ? -1 :
                JsonReader.getPlayerAtIndex(context, index).getInt("healPoint");
        if (hp == -1) throw new Exception("null hp player");
        else return hp;
    }

    public static String getNaration(Context context, int index) {
        String naration = null;
        try {
            String json = loadJsonFromRaw(context.getResources(), GameConstant.CATALOGUE, context.getPackageName());
            JSONObject jsonObject = new JSONObject(json);
            JSONArray catalogues = jsonObject.getJSONArray("catalogues");
            if (index >= 0 && index < catalogues.length()) {
                JSONObject item = catalogues.getJSONObject(index);
                naration = item.getString("naration");
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
        return naration;
    }

    public static int getNumberEnemies(Context context, String levelFile) throws Exception {
        int lenght = -1;
        try {
            String json = loadJsonFromRaw(context.getResources(), levelFile, context.getPackageName());
            JSONObject jsonObject = new JSONObject(json);
            lenght = jsonObject.getJSONArray("enemies").length() - 1;
        } catch (Exception e) {
            e.printStackTrace();
        }
        if (lenght == -1) throw new Exception("null enemies array");

        return lenght;
    }

    private static JSONObject getEnemyAtIndex(Context context, String levelFile, int index) {
        JSONObject enemyObject = null;
        try {
            String json = loadJsonFromRaw(context.getResources(), levelFile, context.getPackageName());
            JSONObject jsonObject = new JSONObject(json);
            JSONArray enemiesArray = jsonObject.getJSONArray("enemies");


            // Vérifiez si l'indice est valide
            if (index >= 0 && index < enemiesArray.length()) {
                enemyObject = enemiesArray.getJSONObject(index);
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
        return enemyObject;
    }

    public static String getEnemieImageSrc(Context context, String levelFile, int index) throws Exception {
        String imgSrc = getEnemyAtIndex(context, levelFile, index).getString("image_sansfond");
        if (imgSrc == null) throw new Exception("null enemieImage");
        else return imgSrc;
    }

    public static String getEnemieDesc(Context context, String levelFile, int index) throws Exception {
        String desc = getEnemyAtIndex(context, levelFile, index).getString("description");
        if (desc == null) throw new Exception("null enemieDescription");
        else return desc;
    }

    private static JSONObject getStats(Context context, String levelFile, int index) {
        JSONObject stats = null;
        try {
            stats = getEnemyAtIndex(context, levelFile, index).getJSONObject("stats");
        } catch (Exception e) {
            e.printStackTrace();
        }
        return stats;
    }

    public static int getEnemieHP(Context context, String levelFile, int index) throws Exception {
        int hp = getStats(context, levelFile, index) == null ? -1 : getStats(context, levelFile, index).getInt("pv");
        if (hp == -1) throw new Exception("null enemieHp");
        else return hp;
    }

    public static String getEnemieName(Context context, String leveFile, int index) throws Exception {
        String name = getEnemyAtIndex(context, leveFile, index) == null ? null : getEnemyAtIndex(context, leveFile, index).getString("nom");
        if (name == null) throw new Exception("null enemieName");
        else return name;
    }

    public static String getEnemieDamageStringFormat(Context context, String levelFile, int index) throws Exception {
        String damage = getStats(context, levelFile, index) == null ? null : getStats(context, levelFile, index).getString("degats");
        if (damage == null) throw new Exception("null enemieDamage");
        else return damage;
    }

    public static String[] getItemsOfEnemie(Context context, String levelFile, int index) throws Exception {
        JSONArray items = getStats(context, levelFile, index) == null || !getStats(context, levelFile, index).has("items") ? null
                : getStats(context, levelFile, index).getJSONArray("items");
        if (items == null) throw new Exception("null enemieItems");
        else {
            String[] itemsString = new String[items.length()];
            for (int i = 0; i < items.length(); i++) {
                itemsString[i] = items.getString(i);
            }
            return itemsString;
        }
    }

    private static JSONObject getWinOfEnemieAttribut(Context context, String levelFile, int index) {
        JSONObject winAttribut = null;
        try {
            winAttribut = getEnemyAtIndex(context, levelFile, index).getJSONObject("win");
        } catch (Exception e) {
            e.printStackTrace();
        }
        return winAttribut;
    }

    private static JSONObject getLooseOfEnemieAttribut(Context context, String levelFile, int index) {
        JSONObject looseAttribut = null;
        try {
            looseAttribut = getEnemyAtIndex(context, levelFile, index).getJSONObject("loose");
        } catch (Exception e) {
            e.printStackTrace();
        }
        return looseAttribut;
    }

    public static String[] getDropOfEnemie(Context context, String levelFile, int index) throws Exception {
        JSONArray items = getWinOfEnemieAttribut(context, levelFile, index) == null ||
                !getWinOfEnemieAttribut(context, levelFile, index).has("dropPossible") ||
                getWinOfEnemieAttribut(context, levelFile, index).getJSONArray("dropPossible").length() == 0 ? null
                : getWinOfEnemieAttribut(context, levelFile, index).getJSONArray("dropPossible");
        if (items == null) throw new Exception("null Drop");
        else {
            String[] itemsDrop = new String[items.length()];
            for (int i = 0; i < items.length(); i++) {
                itemsDrop[i] = items.getString(i);
            }
            return itemsDrop;
        }
    }

    public static String getNarationAfterWinEnemie(Context context, String levelFile, int index) throws Exception {
        String naration = getWinOfEnemieAttribut(context, levelFile, index) == null ||
                !getWinOfEnemieAttribut(context, levelFile, index).has("narration") ? null
                : getWinOfEnemieAttribut(context, levelFile, index).getString("narration");
        if (naration == null) throw new Exception("null enemieNarationAfterWin");
        else return naration;
    }

    public static String getNarationAfterLooseEnemie(Context context, String levelFile, int index) throws Exception {
        String naration = getLooseOfEnemieAttribut(context, levelFile, index) == null || !getLooseOfEnemieAttribut(context, levelFile, index).has("narration") ? null
                : getLooseOfEnemieAttribut(context, levelFile, index).getString("narration");
        if (naration == null) throw new Exception("null enemieNarationAfterLoose");
        else return naration;
    }

    public static int getIndexBoss(Context context, String levelFile) throws Exception {
        int indexBoss = getNumberEnemies(context, levelFile) == -1 ? -1
                : getNumberEnemies(context, levelFile);
        if (indexBoss == -1) throw new Exception("null indexForBoss");
        else return indexBoss;
    }

    public static String[] getChoise(Context context, String levelFile) {
        String[] choise = null;
        try {
            String json = loadJsonFromRaw(context.getResources(), levelFile, context.getPackageName());
            JSONArray choises = new JSONObject(json).getJSONArray("objets");
            choise = new String[choises.length()];
            for (int i = 0; i < choises.length(); i++) {
                choise[i] = choises.getString(i);
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
        return choise;
    }

    public static JSONObject getObject(Context context, String nameOfObject) {
        JSONObject object = null;
        try {
            object = new JSONObject(loadJsonFromRaw(context.getResources(), GameConstant.OBJETS, context.getPackageName()))
                    .getJSONObject(nameOfObject);
        } catch (Exception e) {
            e.printStackTrace();
        }
        return object;
    }

    public static String getObjectName(Context context, String nameOfObject) throws JSONException {
        String name = getObject(context, nameOfObject) == null ? null : getObject(context, nameOfObject).getString("nom");
        if (name == null) throw new JSONException("null objectName");
        else return name;
    }

    public static String getObjectDesc(Context context, String nameOfObject) throws JSONException {
        String desc = getObject(context, nameOfObject) == null ? null : getObject(context, nameOfObject).getString("description");
        if (desc == null) throw new JSONException("null objectDesc");
        else return desc;
    }

    public static String getObjectDamage(Context context, String nameOfObject) throws JSONException {
        String damage = getObject(context, nameOfObject) == null ? null : getObject(context, nameOfObject).getString("degat");
        if (damage == null) throw new JSONException("null objectDamage");
        else return damage;
    }

    public static String getImageObject(Context context, String objet) {
        String imageSrc = null;
        try {
            String json = loadJsonFromRaw(context.getResources(), GameConstant.OBJETS, context.getPackageName());
            imageSrc = new JSONObject(json).
                    getJSONObject(objet).getString("image");

        } catch (Exception e) {
            e.printStackTrace();
        }
        return imageSrc;
    }

    public static JSONArray getItem(Context context, String level) {
        String constanteLevel;
        switch (level) {
            case "niveau1":
                constanteLevel = GameConstant.NIVEAU1;
                break;
            case "niveau2":
                constanteLevel = GameConstant.NIVEAU2;
                break;
            default:
                constanteLevel = GameConstant.NIVEAU3;
                break;
        }

        try {
            Resources res = context.getResources();
            // Charger le JSON correspondant au niveau
            String json = loadJsonFromRaw(res, constanteLevel, context.getPackageName());
            JSONObject jsonObject = new JSONObject(json);
            JSONArray objets = jsonObject.getJSONArray("objets");

            // Récupérer les noms de chaque objet et mélanger
            List<String> objetsList = new ArrayList<>();
            for (int i = 0; i < objets.length(); i++) {
                objetsList.add(objets.getString(i));
            }
            Collections.shuffle(objetsList);

            // Sélectionner 3 objets aléatoires
            JSONArray randomObjets = new JSONArray();
            for (int i = 0; i < 3 && i < objetsList.size(); i++) {
                randomObjets.put(objetsList.get(i));
            }

            // Charger le JSON complet des objets
            json = loadJsonFromRaw(res, "objets", context.getPackageName());
            JSONObject allObjets = new JSONObject(json);

            // Récupérer les objets complets
            JSONArray result = new JSONArray();
            for (int i = 0; i < randomObjets.length(); i++) {
                result.put(allObjets.getJSONObject(randomObjets.getString(i)));
            }

            return result;
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }
    }

    private static String loadJsonFromRaw(Resources res, String resourceName, String packageName) {
        try {
            int resourceId = res.getIdentifier(resourceName, "raw", packageName);
            InputStream inputStream = res.openRawResource(resourceId);
            Scanner scanner = new Scanner(inputStream).useDelimiter("\\A");
            //ne leve pas d'exception si le json est vide lors de la lecture
            String json = scanner.hasNext() ? scanner.next() : "";
            scanner.close();
            return json;
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }
    }
}
