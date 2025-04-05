package Chess;

public class Figure {
    String name ;
    int positionX;
    int positionY;
    boolean isWhite = true;


    public Figure(String name,boolean isWhite,String currentPosition){
        this.name = name;
        this.isWhite = isWhite;
        this.positionX = currentPosition.charAt(0) - 'a';
        this.positionY = 8 - Character.getNumericValue(currentPosition.charAt(1));
    }
    void move(Board board,String targetPosition){
        int row = targetPosition.charAt(0) - 'a';                                       
        int column = 8 - Character.getNumericValue(targetPosition.charAt(1)) ;
        if((row < 0 || row >= 8) || (column < 0||column >=8)){
            System.out.println("Position is out of bounds");
            return;
        }
        else if((board.board[column][row] != null && board.board[column][row].isWhite == this.isWhite))        //ถ้าไม่ว่างและเป็นพวกเดียวกัน
            System.out.printf("The distination is being occupied by the same-side figure \"%s\", Command abort!!!\n\n", board.board[column][row].name);
        
        else{    
            board.board[positionY][positionX] = null;
            board.board[column][row] = this;
            this.positionX = row;
            this.positionY = column;
        }
    }
    
    
}
