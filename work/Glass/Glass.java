package Glass;

import java.util.Scanner;

public class Glass{

    public static void main(String[] args) {
        // Create a Scanner object to get input from the user
        Scanner scanner = new Scanner(System.in);

        // Create two water glasses
        WaterGlass glass1 = new WaterGlass();
        WaterGlass glass2 = new WaterGlass();

        // Get input for water in glass 1
        System.out.print("Enter the water amount in Glass 1 (up to 5 units): ");
        int inputWater1 = scanner.nextInt();
        glass1.fillWater(inputWater1);

        // Get input for water in glass 2
        System.out.print("Enter the water amount in Glass 2 (up to 5 units): ");
        int inputWater2 = scanner.nextInt();
        glass2.fillWater(inputWater2);

        // Display the water levels in both glasses
        System.out.println("Water level in Glass 1: " + glass1.getWaterLevel() + " units");
        System.out.println("Water level in Glass 2: " + glass2.getWaterLevel() + " units");

       

        // Pour water from glass 1 to glass 2
        System.out.print("Enter the amount of water to pour from Glass 1 to Glass 2: ");
        int transferAmount = scanner.nextInt();
        glass1.pourWater(glass2, transferAmount);

        // Display the water levels in both glasses after pouring
        System.out.println("Water level in Glass 1: " + glass1.getWaterLevel() + " units");
        System.out.println("Water level in Glass 2: " + glass2.getWaterLevel() + " units");

        // Pour water from glass 2 to glass 1 until empty
        System.out.print("Enter the amount of water to pour from Glass 2 to Glass 1 : ");
        transferAmount = scanner.nextInt();
        glass2.pourWater(glass1, transferAmount);

        // Display the water levels in both glasses after pouring
        System.out.println("Water level in Glass 1: " + glass1.getWaterLevel() + " units");
        System.out.println("Water level in Glass 2: " + glass2.getWaterLevel() + " units");

        // Close the Scanner
        scanner.close();
    }
}


