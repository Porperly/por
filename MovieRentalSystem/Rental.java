public class Rental {
    int id;
    int userId;
    int movieId;
    double rentalFee;
    boolean active;  // true = active rental, false = returned

    public Rental(int id, int userId, int movieId, double rentalFee) {
        this.id = id;
        this.userId = userId;
        this.movieId = movieId;
        this.rentalFee = rentalFee;
        this.active = true;  // Initialize as active
    }

    @Override
    public String toString() {
        return "Rental{id=" + id + ", userId=" + userId + ", movieId=" + movieId +
                ", fee=" + rentalFee + ", active=" + active + "}";
    }
}