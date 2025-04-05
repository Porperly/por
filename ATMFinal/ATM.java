import java.util.ArrayList;
import java.util.Scanner;

public class ATM {
    private double btcRate;

    public void setBtcRate(double rate) {
        this.btcRate = rate;
    }

    public void adminLogin(ArrayList<Account> accounts, Scanner scanner) {
        System.out.print("Enter Admin Username: ");
        String username = scanner.nextLine();
        System.out.print("Enter Admin Password: ");
        String password = scanner.nextLine();

        for (Account account : accounts) {
            if (account instanceof Manager && account.getUsername().equals(username) && account.getPassword().equals(password)) {
                System.out.println("Admin login successful.");
                adminMenu(accounts, scanner);
                return;
            }
        }
        System.out.println("Invalid admin credentials.");
    }

    public void adminMenu(ArrayList<Account> accounts, Scanner scanner) {
        while (true) {
            System.out.println("=== Admin Menu ===");
            System.out.println("1. Create Customer Account");
            System.out.println("2. Logout");
            System.out.print("Select an option: ");
            int choice = scanner.nextInt();
            scanner.nextLine();

            switch (choice) {
                case 1:
                    // สร้างบัญชีลูกค้า
                    System.out.print("Enter Customer ID: ");
                    String customerId = scanner.nextLine();
                    System.out.print("Enter Customer Name: ");
                    String customerName = scanner.nextLine();
                    System.out.print("Enter Customer Gender: ");
                    String customerGender = scanner.nextLine();
                    System.out.print("Enter Customer Username: ");
                    String customerUsername = scanner.nextLine();
                    System.out.print("Enter Customer Password: ");
                    String customerPassword = scanner.nextLine();
                    System.out.print("Enter Initial Balance (THB): ");
                    double initialBalance = scanner.nextDouble();
                    scanner.nextLine();

                    Account newCustomer = new Account(customerId, customerName, customerGender, customerUsername, customerPassword, initialBalance);
                    accounts.add(newCustomer);
                    System.out.println("Customer account created successfully!");
                    break;
                case 2:
                    System.out.println("Logging out...");
                    return;
                default:
                    System.out.println("Invalid option. Please try again.");
            }
        }
    }

    public void customerLogin(ArrayList<Account> accounts, Scanner scanner) {
        System.out.print("Enter Username: ");
        String username = scanner.nextLine();
        System.out.print("Enter Password: ");
        String password = scanner.nextLine();

        for (Account account : accounts) {
            if (account instanceof Account && account.getUsername().equals(username) && account.getPassword().equals(password)) {
                System.out.println("Customer login successful.");
                customerMenu((Account) account, accounts, scanner);
                return;
            }
        }
        System.out.println("Invalid customer credentials.");
    }

    public void customerMenu(Account customer, ArrayList<Account> accounts, Scanner scanner) {
        while (true) {
            System.out.println("=== Customer Menu ===");
            System.out.println("1. Check Balance (THB and BTC)");
            System.out.println("2. Deposit (THB or BTC)");
            System.out.println("3. Withdraw (THB or BTC)");
            System.out.println("4. Transfer Money (THB or BTC)");
            System.out.println("5. Logout");
            System.out.print("Select an option: ");
            int choice = scanner.nextInt();
            scanner.nextLine();

            switch (choice) {
                case 1:
                    // ตรวจสอบยอดเงิน
                    System.out.println("Balance: ");
                    System.out.println("- THB: " + customer.getBalanceTHB() + " THB");
                    System.out.println("- BTC: " + customer.convertToBTC(btcRate) + " BTC");
                    break;
                case 2:
                    // ฝากเงิน
                    System.out.println("Deposit Options:");
                    System.out.println("1. Deposit THB");
                    System.out.println("2. Deposit BTC");
                    System.out.print("Select an option: ");
                    int depositChoice = scanner.nextInt();
                    System.out.print("Enter amount: ");
                    double depositAmount = scanner.nextDouble();

                    if (depositChoice == 1) {
                        customer.depositTHB(depositAmount);
                        System.out.println("Deposited " + depositAmount + " THB successfully!");
                    } else if (depositChoice == 2) {
                        customer.depositBTC(depositAmount, btcRate);
                        System.out.println("Deposited " + depositAmount + " BTC successfully!");
                    } else {
                        System.out.println("Invalid option. Try again.");
                    }
                    break;
                case 3:
                    // ถอนเงิน
                    System.out.println("Withdraw Options:");
                    System.out.println("1. Withdraw THB");
                    System.out.println("2. Withdraw BTC");
                    System.out.print("Select an option: ");
                    int withdrawChoice = scanner.nextInt();
                    System.out.print("Enter amount: ");
                    double withdrawAmount = scanner.nextDouble();

                    if (withdrawChoice == 1) {
                        if (withdrawAmount > customer.getBalanceTHB()) {
                            System.out.println("Insufficient THB balance!");
                        } else {
                            customer.withdrawTHB(withdrawAmount);
                            System.out.println("Withdrawn " + withdrawAmount + " THB successfully!");
                        }
                    } else if (withdrawChoice == 2) {
                        if (withdrawAmount * btcRate > customer.getBalanceTHB()) {
                            System.out.println("Insufficient THB balance for BTC withdrawal!");
                        } else {
                            customer.withdrawBTC(withdrawAmount, btcRate);
                            System.out.println("Withdrawn " + withdrawAmount + " BTC successfully!");
                        }
                    } else {
                        System.out.println("Invalid option. Try again.");
                    }
                    break;
                case 4:
                    // โอนเงิน
                    System.out.println("Transfer Options:");
                    System.out.println("1. Transfer THB");
                    System.out.println("2. Transfer BTC");
                    System.out.print("Select an option: ");
                    int transferChoice = scanner.nextInt();
                    scanner.nextLine();

                    System.out.print("Enter recipient username: ");
                    String recipientUsername = scanner.nextLine();

                    Account recipient = findAccountByUsername(accounts, recipientUsername);
                    if (recipient == null) {
                        System.out.println("Recipient not found. Please try again.");
                        break;
                    }

                    System.out.print("Enter amount: ");
                    double transferAmount = scanner.nextDouble();

                    if (transferChoice == 1) {
                        if (transferAmount > customer.getBalanceTHB()) {
                            System.out.println("Insufficient THB balance!");
                        } else {
                            customer.withdrawTHB(transferAmount);
                            recipient.depositTHB(transferAmount);
                            System.out.println("Transferred " + transferAmount + " THB to " + recipient.getUsername() + " successfully!");
                        }
                    } else if (transferChoice == 2) {
                        if (transferAmount * btcRate > customer.getBalanceTHB()) {
                            System.out.println("Insufficient THB balance for BTC transfer!");
                        } else {
                            customer.withdrawBTC(transferAmount, btcRate);
                            recipient.depositBTC(transferAmount, btcRate);
                            System.out.println("Transferred " + transferAmount + " BTC to " + recipient.getUsername() + " successfully!");
                        }
                    } else {
                        System.out.println("Invalid option. Try again.");
                    }
                    break;

                case 5:
                    // ออกจากระบบ
                    System.out.println("Logging out...");
                    return;

                default:
                    System.out.println("Invalid option. Try again.");
            }
        }
    }

    private Account findAccountByUsername(ArrayList<Account> accounts, String username) {
        for (Account account : accounts) {
            if (account.getUsername().equals(username)) {
                return account;
            }
        }
        return null;
    }
}
