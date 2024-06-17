package com.example.saes401.utilities;

import android.os.Parcel;
import android.os.Parcelable;

public class Item implements Parcelable {
    private String name;
    private String damage;
    private String image;
    private String desc;

    public Item(String name, String damage, String image, String desc) {
        this.name = name;
        this.damage = damage;
        this.image = image;
        this.desc = desc;
    }

    @Override
    public void writeToParcel(Parcel dest, int flags) {
        dest.writeString(name);
        dest.writeString(damage);
        dest.writeString(image);
        dest.writeString(desc);
    }

    @Override
    public int describeContents() {
        return 0;
    }

    protected Item(Parcel in) {
        name = in.readString();
        damage = in.readString();
        image = in.readString();
        desc = in.readString();
    }

    public static final Parcelable.Creator<Item> CREATOR = new Creator<Item>() {
        @Override
        public Item createFromParcel(Parcel in) {
            return new Item(in);
        }

        @Override
        public Item[] newArray(int size) {
            return new Item[size];
        }
    };

    public String getName() {
        return name;
    }

    public String getDamage() {
        return damage;
    }

    public void setDamage(String newDamage) {
        damage = newDamage;
    }

    public String getImage() {
        return image;
    }

    public String getDesc() {
        return desc;
    }
}
