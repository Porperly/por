public class Person {
    private String nationalID;
    private String fullName;
    private String gender;

    public Person(String nationalID, String fullName, String gender) {
        this.nationalID = nationalID;
        this.fullName = fullName;
        this.gender = gender;
    }

    public String getNationalID() {
        return nationalID;
    }

    public String getFullName() {
        return fullName;
    }

    public String getGender() {
        return gender;
    }
}
