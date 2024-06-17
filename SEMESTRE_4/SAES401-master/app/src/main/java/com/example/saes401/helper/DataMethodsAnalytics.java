package com.example.saes401.helper;

public interface DataMethodsAnalytics {
    /*
     put methods -> put data to the dataBase
     add methods -> add data to the arrayList or attribute
     get methods -> get data from the arrayList
     */
    public abstract void addStart(); // get time start game LocalDateTime

    public abstract void addEnd(); // get time end game LocalDateTime

    public abstract String getTime() throws Exception; // get end - start LocalDateTime

    public abstract void addDamageToPlayer(int damage); // add to arrayList damage to player

    public abstract int getMaxDamageToPlayer(); // get damage to player

    public abstract void addDamageToEnemy(int damage); // add to arrayList damage to enemy by player

    public abstract int getMaxDamageToEnemy(); // get damage to enemy by player

    public abstract void addHeartLost(int heartLost); // add to arrayList heartLost

    public abstract int getHeartLost(); // get heartLost

    public abstract void addLastScore(String score); // add to attribute score

    public abstract String getLastScore(); // get attribute score

    public abstract void addWin(boolean b); // add to attribute win

    public abstract boolean getWin(); // get attribute win

    public abstract void putAllData(); // put all data
}
