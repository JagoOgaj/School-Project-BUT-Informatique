package com.example.saes401.entities;

public abstract class GameCharacter {
    private int HP;
    private String name;

    public GameCharacter(int HP, String name) {
        this.HP = HP;
        this.name = name;
    }

    public GameCharacter(int HP) {
        this.HP = HP;
    }

    public int getHPEnemie() {
        return HP;
    }

    public void setHP(int HP) {
        this.HP = HP;
    }

    public String getName() {
        return this.name;
    }

    public void setName(String name) {
        this.name = name;
    }
}
