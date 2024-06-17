package com.example.saes401.entities;

import android.os.Parcel;
import android.os.Parcelable;

import androidx.annotation.NonNull;

import com.example.saes401.helper.GameConstant;
import com.example.saes401.utilities.Inventory;
import com.example.saes401.utilities.Item;

public class Player extends GameCharacter implements Parcelable {
    private Inventory inventory;
    private int HP;
    private int currentItem;
    private String degat;
    private String image;
    private String name;

    public Player(int HP, String degat, String image, String name) {
        super(HP);
        this.HP = HP;
        this.degat = degat;
        this.image = image;
        this.name = name;
        this.inventory = new Inventory(GameConstant.DEFAULT_INVENTORY_SLOT);
        this.currentItem = 0;
    }

    protected Player(Parcel in) {
        super(in.readInt());
        HP = in.readInt();
        degat = in.readString();
        image = in.readString();
        name = in.readString();
        inventory = in.readParcelable(Inventory.class.getClassLoader());
    }

    public static final Creator<Player> CREATOR = new Creator<Player>() {
        @Override
        public Player createFromParcel(Parcel in) {
            return new Player(in);
        }

        @Override
        public Player[] newArray(int size) {
            return new Player[size];
        }
    };

    public void setInventory(Item item) throws Exception {
        this.inventory.setItemsInventory(item);
    }

    public void setInentoryRandom(Item item) throws Exception {
        this.inventory.addItemRandomPlayer(item);
    }

    @Override
    public int describeContents() {
        return 0;
    }

    @Override
    public void writeToParcel(@NonNull Parcel dest, int flags) {
        dest.writeInt(getHPplayer());
        dest.writeInt(HP);
        dest.writeString(degat);
        dest.writeString(image);
        dest.writeString(name);
        dest.writeParcelable(inventory, flags);
    }

    public Inventory getInventory() {
        return inventory;
    }

    public boolean isFullinventory() throws Exception {
        return inventory.isFullInventory();
    }

    public Item getItem() {
        return inventory.getItem(this.currentItem);
    }

    public void removeItem(Item item) {
        this.inventory.removeItem(item);
    }

    public int getHPplayer() {
        return HP;
    }

    public String getDegat() {
        return degat;
    }

    public String getImage() {
        return image;
    }

    @Override
    public String getName() {
        return name;
    }

    public void setHP(int HP) {
        this.HP = HP;
    }

    public void setCurrentItem(int currentItem) {
        this.currentItem = currentItem;
    }
}