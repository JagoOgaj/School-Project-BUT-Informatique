package com.example.saes401.entities;

import android.os.Parcel;
import android.os.Parcelable;

import com.example.saes401.utilities.Inventory;
import com.example.saes401.utilities.Item;

import java.util.Random;

public class Enemie extends GameCharacter implements Parcelable {
    private String name;
    private int HP;
    private int currentLevelFile;
    private int index;
    private Inventory inventory;
    private String damage;
    private String imageSrc;

    public Enemie(int HP, String name, int currentLevelFile, int index, Inventory inventory, String damage, String imageSrc) {
        super(HP, name);
        this.name = name;
        this.HP = HP;
        this.currentLevelFile = currentLevelFile;
        this.index = index;
        this.inventory = inventory;
        this.damage = damage;
        this.imageSrc = imageSrc;
    }

    @Override
    public int describeContents() {
        return 0;
    }

    @Override
    public void writeToParcel(Parcel dest, int flags) {
        dest.writeString(name);
        dest.writeInt(HP);
        dest.writeInt(currentLevelFile);
        dest.writeInt(index);
        dest.writeParcelable(inventory, flags);
        dest.writeString(imageSrc);
    }

    public static final Parcelable.Creator<Enemie> CREATOR = new Parcelable.Creator<Enemie>() {
        @Override
        public Enemie createFromParcel(Parcel in) {
            return new Enemie(in);
        }

        @Override
        public Enemie[] newArray(int size) {
            return new Enemie[size];
        }
    };

    protected Enemie(Parcel in) {
        super(in.readInt(), in.readString());
        name = in.readString();
        HP = in.readInt();
        currentLevelFile = in.readInt();
        index = in.readInt();
        inventory = in.readParcelable(Inventory.class.getClassLoader());
        imageSrc = in.readString();
    }

    public void setName(String name) {
        this.name = name;
    }

    public void setHP(int HP) {
        this.HP = HP;
    }

    public void setCurrentLevelFile(int currentLevelFile) {
        this.currentLevelFile = currentLevelFile;
    }

    public void setIndex(int index) {
        this.index = index;
    }

    public void setInventory(Inventory inventory) {
        this.inventory = inventory;
    }

    public void setDamage(String damage) {
        this.damage = damage;
    }

    public String getName() {
        return name;
    }

    public int getHPEnemie() {
        return HP;
    }

    public int getCurrentLevelFile() {
        return currentLevelFile;
    }

    public int getIndex() {
        return index;
    }

    public Inventory getInventory() {
        return inventory;
    }

    public void removeItem(Item item) {
        this.inventory.removeItem(item);
    }

    public Item getItem() throws Exception {
        //admet que son inventaire est full
        Random random = new Random();
        return getInventory().getItem(random.nextInt(getInventory().getCurentLength()));
    }

    public String getDamage() {
        return damage;
    }

    public String getImageSrc() {
        return imageSrc;
    }
}
