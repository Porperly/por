public class Movie {
    int id;
    String title;
    int quantity;
    double rentalFee;

    public Movie(int id, String title, int quantity, double rentalFee) {
        this.id = id;
        this.title = title;
        this.quantity = quantity;
        this.rentalFee = rentalFee;
    }

    @Override
    public String toString() {
        return "Movie{id=" + id + ", title='" + title + "', quantity=" + quantity + ", fee=" + rentalFee + "}";
    }
}