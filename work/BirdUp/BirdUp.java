package BirdUp;
public class BirdUp {
    public static void main(String[] args) {
        BirdClass bird1 = new BirdClass();
        bird1.myBird("Un", 3, 50, 'F');

        BirdClass bird2 = new BirdClass();
        bird2.myBird("Lama", 3, 45, 'M');

        bird1.speak();
        bird2.speak();

        bird1.eat(35);
        bird2.eat(30);

        bird1.poop(10);
        bird2.poop(15);

        bird1.breed(bird2);
        
    }
}