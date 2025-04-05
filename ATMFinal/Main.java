import java.util.ArrayList;
import java.util.Scanner;

public class Main {
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        ArrayList<Account> accounts = new ArrayList<>();
        ATM atm = new ATM();

        // สร้างบัญชีแอดมินเริ่มต้น
        System.out.println("=== Setup Admin Account ===");
        System.out.print("Enter Admin ID: ");
        String adminId = scanner.nextLine();
        System.out.print("Enter Admin Name: ");
        String adminName = scanner.nextLine();
        System.out.print("Enter Admin Gender: ");
        String adminGender = scanner.nextLine();
        System.out.print("Enter Admin Username: ");
        String adminUsername = scanner.nextLine();
        System.out.print("Enter Admin Password: ");
        String adminPassword = scanner.nextLine();

        Manager admin = new Manager(adminId, adminName, adminGender, adminUsername, adminPassword);
        accounts.add(admin);

        // ตั้งค่าเรท BTC
        System.out.println("=== Set BTC exchange rate ===");
        System.out.print("Enter BTC rate: ");
        double btcRate = scanner.nextDouble();
        scanner.nextLine();
        atm.setBtcRate(btcRate);

        // แสดงเมนูหลัก
        while (true) {
            System.out.println("=== ATM System ===");
            System.out.println("1. Admin Login");
            System.out.println("2. Customer Login");
            System.out.println("3. Exit");
            System.out.print("Select an option: ");
            int choice = scanner.nextInt();
            scanner.nextLine();

            switch (choice) {
                case 1:
                    // เมนูแอดมิน
                    atm.adminLogin(accounts, scanner);
                    break;
                case 2:
                    // เมนูลูกค้า
                    atm.customerLogin(accounts, scanner);
                    break;
                case 3:
                    // ออกจากระบบ
                    System.out.println("Exiting the system. Goodbye!");
                    scanner.close();
                    return;
                default:
                    System.out.println("Invalid option. Please try again.");
            }
        }
    }
}
