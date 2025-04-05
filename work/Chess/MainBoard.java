package Chess;

public class MainBoard {
    public static void main(String[] args) {
        Board brd = new Board();
        brd.boardInitiate();
        brd.freeMove("A", "a2");
        brd.freeMove("B", "b3");
        brd.freeMove("R", "d6");
        brd.freeMove("L", "e3");
    }
}
