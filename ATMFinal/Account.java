public class Account {
    private String id;
    private String name;
    private String gender;
    private String username;
    private String password;
    private double balanceTHB;

    public Account(String id, String name, String gender, String username, String password, double initialBalance) {
        this.id = id;
        this.name = name;
        this.gender = gender;
        this.username = username;
        this.password = password;
        this.balanceTHB = initialBalance;
    }

    public String getUsername() {
        return username;
    }

    public String getPassword() {
        return password;
    }

    public double getBalanceTHB() {
        return balanceTHB;
    }

    public void depositTHB(double amount) {
        balanceTHB += amount;
    }

    public void withdrawTHB(double amount) {
        balanceTHB -= amount;
    }

    public void depositBTC(double amountBTC, double btcRate) {
        balanceTHB += amountBTC * btcRate;
    }

    public void withdrawBTC(double amountBTC, double btcRate) {
        balanceTHB -= amountBTC * btcRate;
    }

    public double convertToBTC(double btcRate) {
        return balanceTHB / btcRate;
    }
}
