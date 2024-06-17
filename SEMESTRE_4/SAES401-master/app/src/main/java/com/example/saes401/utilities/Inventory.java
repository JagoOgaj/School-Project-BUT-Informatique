package com.example.saes401.utilities;


import android.os.Parcel;
import android.os.Parcelable;

import java.util.Random;

public class Inventory implements Parcelable {
    private Item[] items;
    private int slots;

    public Inventory(int slots) {
        items = new Item[slots];
        this.slots = slots;
    }

    @Override
    public void writeToParcel(Parcel dest, int flags) {
        dest.writeInt(slots);
        dest.writeTypedArray(items, flags);
    }

    // Méthode pour décrire le type du contenu du Parcel
    @Override
    public int describeContents() {
        return 0;
    }

    // Constructeur spécial pour recréer l'objet depuis le Parcel
    protected Inventory(Parcel in) {
        slots = in.readInt();
        items = in.createTypedArray(Item.CREATOR);
    }

    // Parcelable CREATOR permettant de recréer les objets Inventory
    public static final Creator<Inventory> CREATOR = new Creator<Inventory>() {
        @Override
        public Inventory createFromParcel(Parcel in) {
            return new Inventory(in);
        }

        @Override
        public Inventory[] newArray(int size) {
            return new Inventory[size];
        }
    };

    public void setItemsInventory(Item newItem) throws Exception {
        if (!canInserItem()) throw new Exception("can't insert into");
        items[getLastIndex()] = newItem;
    }

    public void addItemsEnemie(Item item) throws Exception {
        items[getLastIndex()] = item;
    }

    public void setCapacityInventory(int newCapa) {
        Item[] newItems = new Item[newCapa];
        for (int i = 0; i < this.items.length; i++)
            newItems[i] = items[i];
        items = newItems;
    }

    public void addItemRandomPlayer(Item item) throws Exception {
        Random random = new Random();
        this.items[random.nextInt(this.items.length)] = item;
    }

    public int getCapacityInventory() {
        return this.slots;
    }

    public int getCurentLength() throws Exception {
        return getLastIndex();
    }

    public Item[] getItemsInventory() {
        return items;
    }

    public Item getItem(int i) {
        return items[i];
    }

    public boolean isEmptyInventory() {
        for (Item item : items) {
            if (item != null) {
                return false;
            }
        }
        return true;
    }


    public void removeItem(Item item) {
        int index = getIndexOfItem(item);
        if (index < 0 || index >= slots) {
            throw new IllegalArgumentException("Index out of bounds or array is null");
        }

        Item[] newArray = new Item[slots];

        // Copier les éléments avant l'index
        for (int i = 0; i < index; i++) {
            newArray[i] = items[i];
        }

        // Copier les éléments après l'index
        for (int i = index; i < slots - 1; i++) {
            newArray[i] = items[i + 1];
        }
        this.items = newArray;
    }

    public int getIndexOfItem(Item item) {
        for (int i = 0; i < items.length; i++)
            if (items[i].equals(item)) return i;
        return -1;
    }

    public boolean isFullInventory() throws Exception {
        return getLastIndex() == slots;
    }

    private boolean canInserItem() throws Exception {
        int index = getLastIndex();
        return index < slots;
    }


    private int getLastIndex() throws Exception {
        for (int i = 0; i < this.items.length; i++)
            if (this.items[i] == null) return i;
        return slots;
    }
}
