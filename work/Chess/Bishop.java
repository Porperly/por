package Chess;
public class Bishop extends Figure {

    public Bishop(String name,boolean isWhite, String currentPosition) {
        super(name, isWhite, currentPosition);
    }

    
    void move(Board board, String targetPosition) {
        int row = targetPosition.charAt(0) - 'a';
        int column = 8 - Character.getNumericValue(targetPosition.charAt(1));

        if((row< 0 || row >= 8) || (column < 0||column >=8)){
            System.out.println("Position is out of bounds");
            return;
        }
        else if((board.board[column][row] != null && board.board[column][row].isWhite == this.isWhite))       //ถ้าไม่ว่างและเป็นพวกเดียวกัน
            System.out.printf("The distination is being occupied by the same-side figure \"%s\", Command abort!!!\n\n", board.board[column][row].name);
            
            
        int deltaX = row - this.positionX;
        int deltaY = column - this.positionY;

        
        if (Math.abs(deltaX) == Math.abs(deltaY)) {
            System.out.println("Bishop can't move there");
            return;
        }
        
        else{
        board.board[positionY][positionX] = null;
        board.board[column][row] = this;
        this.positionX = row;
        this.positionY = column;
        }
    }
}