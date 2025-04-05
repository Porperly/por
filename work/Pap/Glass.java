package Pap;

public class Glass {
    private int waterLevel;
    private final int maxCapacity = 5;

    public Glass() {
        this.waterLevel = 0;
    }

    public void fill(int amount) {
        if (amount <= 0) {
            System.out.println("Invalid amount. Please enter a positive value.");
        } else if (waterLevel + amount > maxCapacity) {
            System.out.println("Cannot fill the glass. Exceeds maximum capacity.");
        } else {
            waterLevel += amount;
            System.out.println("Glass filled with " + amount + " units of water.");
        }
    }

    public void pour(int amount) {
        if (amount <= 0) {
            System.out.println("Invalid amount. Please enter a positive value.");
        } else if (waterLevel - amount < 0) {
            System.out.println("Cannot pour. Insufficient water in the glass.");
        } else {
            waterLevel -= amount;
            System.out.println("Poured " + amount + " units of water from the glass.");
        }
    }

    public void empty() {
        waterLevel = 0;
        System.out.println("Glass emptied.");
    }

    public int getWaterLevel() {
        return waterLevel;
    }

    public void displayWaterLevel() {
        System.out.println("Water level in the glass: " + waterLevel + " units");
    }
}
