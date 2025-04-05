package SandClocks;

import java.util.Scanner;

public class SandClocksAPP {
    public static void run() {
        Scanner scanner = new Scanner(System.in);

        boolean continueProgram = true;

        while (continueProgram) {
            System.out.print("Enter initial sand amount for Clock A: ");
            int sandAmountA = scanner.nextInt();

            System.out.println("\nStarting with " + sandAmountA + " sand total.");
            int totalSand = sandAmountA;

            MainSandClock clockA = new MainSandClock();

            

            System.out.print("\nEnter the degrees to rotate Clock A (90 or 180): ");
            int degrees = scanner.nextInt();

            if (degrees != 90 && degrees != 180) {
                System.out.println("\nInvalid input. Please enter either 90 or 180.\n");
                continue;
            }

            while (totalSand >= 1000) {
                clockA.rotateClockwise(degrees);
                totalSand -= 1000;
                System.out.println("Clock A after rotating " + degrees + " degrees " );
                System.out.println("Remaining sand: " + totalSand);

                try {
                    Thread.sleep(1000); // หน่วงเวลาลงทีละ 1 วินาที (1000 มิลลิวินาที)
                } catch (InterruptedException e) {
                    e.printStackTrace();
                }
            }

            System.out.print("\nDo you want to continue? (Y/N): ");
            String choice = scanner.next();
            if (!choice.equalsIgnoreCase("Y")) {
                continueProgram = false;
            }
        }

        scanner.close();
    }
}