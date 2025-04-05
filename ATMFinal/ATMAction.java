public interface ATMAction {
    void checkBalance();
    void deposit(double amount);
    void withdraw(double amount);
    void transfer(Account targetAccount, double amount);
}
