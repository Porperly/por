package Glass;

class WaterGlass {
    // Water level in the glass
    private int waterLevel;

    // Maximum water level in the glass
    private final int maxCapacity = 5;

    // Fill water to the top
    public void fillToFull() {
        waterLevel = maxCapacity;
    }

    // Fill water according to the specified amount
    public void fillWater(int amount) {
        if (amount >= 0) {
            if (amount <= maxCapacity - waterLevel) {
                waterLevel += amount;
            } else {
                System.out.println("Exceeded maximum capacity. Filling the glass to the top.");
                fillToFull();
            }
        } else {
            System.out.println("Please enter a non-negative water amount.");
        }
    }

    // Pour water to another glass according to the specified amount
    public void pourWater(WaterGlass targetGlass, int amount) {
        if (amount >= 0) {
            if (amount <= waterLevel) {
                waterLevel -= amount;
                targetGlass.fillWater(amount);
            } else {
                System.out.println("Attempting to pour more water than available. Pouring all remaining water.");
                targetGlass.fillWater(waterLevel);
                waterLevel = 0;
            }
        } else {
            System.out.println("Please enter a non-negative water amount.");
        }
    }

    // Get the water level in the glass
    public int getWaterLevel() {
        return waterLevel;
    }
}