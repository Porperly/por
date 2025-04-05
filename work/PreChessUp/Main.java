package PreChessUp;

public class Main {
    public static void main(String[] args) {
        // สร้างอ็อบเจ็กต์ Figure
        Figure king = new Figure('K', "white", "e1");
        
        // สร้างอ็อบเจ็กต์ Board
        Board board = new Board();
        
        // แสดงบอร์ดเริ่มต้น
        board.displayBoard();
        
        // ทดลองเคลื่อนตำแหน่งของเบี้ยไปยัง 
        System.out.println("Moving king to :");
        king.freeMove("e3");
        board.freeMove(king, "e3");
    }
}