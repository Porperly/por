package PreChessUp;

public class Figure  {
    public char name;
    public String color;
    public String position;
    

    public Figure(char name, String color,String position){
        this.name = name;
        this.color = color;
        this.position = position;
    }
    public void freeMove(String position){
        int row = position.charAt(0) - 'a';                                       
        int column = 8 - Character.getNumericValue(position.charAt(1)) ;

        if(row < 0 || row >= 8 || column < 0||column >=8){
            System.out.println("Position is out of bounds");
            return;
        }
        this.position = position;
        
    }
    
}


