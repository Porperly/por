import tkinter as tk
from tkinter import messagebox
from PIL import Image, ImageTk
from collections import Counter, defaultdict

class VendingMachine:
    def __init__(self, root):
        self.root = root
        self.root.title("Vending Machine - Cars")
        self.cars = {
            "Honda Civic": {"price": 30000, "details": "Compact car with good fuel efficiency.", "image": "honda.png"},
            "Toyota Corolla": {"price": 25000, "details": "Reliable sedan with advanced safety features.", "image": "toyota.png"},
            "Tesla Model 3": {"price": 35000, "details": "Electric vehicle with autonomous driving capabilities.", "image": "tesla.png"}
        }
        self.selected_car = None
        self.balance = 0.0
        self.purchase_history = []
        self.total_revenue = 0.0
        self.car_image = None
        self.create_widgets()
        self.center_window(450, 600)

    def center_window(self, width, height):
        screen_width = self.root.winfo_screenwidth()
        screen_height = self.root.winfo_screenheight()
        x = (screen_width - width) // 2
        y = (screen_height - height) // 2
        self.root.geometry(f'{width}x{height}+{x}+{y}')

    def create_widgets(self):
        title_label = tk.Label(self.root, text="Car Vending Machine", font=("Helvetica", 18, "bold"))
        title_label.grid(row=0, column=0, columnspan=2, pady=10)

        car_frame = tk.LabelFrame(self.root, text="Select Your Car", padx=10, pady=10, font=("Helvetica", 12, "bold"))
        car_frame.grid(row=1, column=0, columnspan=2, padx=20, pady=10, sticky="ew")

        row = 0
        for car, info in self.cars.items():
            car_button = tk.Button(car_frame, text=f"{car} - ${info['price']}",
                                   command=lambda c=car: self.select_car(c),
                                   font=("Helvetica", 12), width=30)
            car_button.grid(row=row, column=0, pady=5)
            row += 1

        self.info_label = tk.Label(self.root, text="Select a car", font=("Helvetica", 12), anchor="w", justify="left", wraplength=400)
        self.info_label.grid(row=2, column=0, columnspan=2, pady=10)

        self.car_image_label = tk.Label(self.root)
        self.car_image_label.grid(row=3, column=0, columnspan=2, pady=10)

        button_frame = tk.Frame(self.root)
        button_frame.grid(row=4, column=0, columnspan=2, pady=10)

        self.purchase_button = tk.Button(button_frame, text="Purchase", command=self.purchase_car, bg="green", fg="white", font=("Helvetica", 12), width=15)
        self.purchase_button.grid(row=0, column=0, padx=10)

        self.refund_button = tk.Button(button_frame, text="Refund", command=self.refund_money, bg="blue", fg="white", font=("Helvetica", 12), width=15)
        self.refund_button.grid(row=0, column=1, padx=10)

        balance_frame = tk.LabelFrame(self.root, text="Balance", padx=10, pady=10, font=("Helvetica", 12, "bold"))
        balance_frame.grid(row=5, column=0, columnspan=2, padx=20, pady=10, sticky="ew")

        self.balance_label = tk.Label(balance_frame, text=f"Balance: ${self.balance:.2f}", font=("Helvetica", 12))
        self.balance_label.grid(row=0, column=0, columnspan=2, pady=5)

        self.add_money_entry = tk.Entry(balance_frame, font=("Helvetica", 12), width=10)
        self.add_money_entry.grid(row=1, column=0, padx=5, pady=5, sticky="e")

        self.add_money_button = tk.Button(balance_frame, text="Add Money", command=self.add_money, font=("Helvetica", 12))
        self.add_money_button.grid(row=1, column=1, padx=5, pady=5, sticky="w")

        self.history_button = tk.Button(self.root, text="View Purchase History", command=self.show_purchase_history, bg="orange", fg="white", font=("Helvetica", 12), width=30)
        self.history_button.grid(row=6, column=0, columnspan=2, padx=20, pady=10)

    def select_car(self, car):
        self.selected_car = car
        price = self.cars[car]['price']
        self.info_label.config(text=f"Selected: {car} - ${price}\n{self.cars[car]['details']}")

        # Load car image
        image_file = self.cars[car]['image']
        try:
            image = Image.open(image_file)
            image = image.resize((200, 150), Image.LANCZOS)  # Resize the image properly
            self.car_image = ImageTk.PhotoImage(image)
            self.car_image_label.config(image=self.car_image)
        except Exception as e:
            self.car_image_label.config(text="Image not found", image='')
            print(f"Error loading image: {e}")

    def purchase_car(self):
        if self.selected_car:
            price = self.cars[self.selected_car]['price']
            if self.balance >= price:
                self.balance -= price
                self.total_revenue += price
                self.purchase_history.append({"car": self.selected_car, "price": price})

                messagebox.showinfo("Purchase Successful", f"You purchased {self.selected_car} for ${price}")
                self.reset_selection()
            else:
                messagebox.showwarning("Insufficient Funds", "You don't have enough balance to make this purchase.")
        else:
            messagebox.showwarning("No Selection", "Please select a car to purchase.")
        self.update_balance_label()

    def add_money(self):
        try:
            amount = float(self.add_money_entry.get())
            if amount > 0:
                self.balance += amount
                self.add_money_entry.delete(0, tk.END)
                self.update_balance_label()
            else:
                messagebox.showwarning("Invalid Amount", "Please enter a positive amount.")
        except ValueError:
            messagebox.showwarning("Invalid Input", "Please enter a valid number.")

    def update_balance_label(self):
        self.balance_label.config(text=f"Balance: ${self.balance:.2f}")

    def reset_selection(self):
        self.selected_car = None
        self.info_label.config(text="Select a car")
        self.car_image_label.config(image='')

    def refund_money(self):
        if self.balance > 0:
            refund_amount = self.balance
            self.balance = 0.0
            self.update_balance_label()
            messagebox.showinfo("Refund", f"Refunded ${refund_amount:.2f}")
        else:
            messagebox.showwarning("No Balance", "There is no money to refund.")

    def show_purchase_history(self):
        if self.purchase_history:
            # สร้างรายการประวัติการซื้อแบบแยกแต่ละคันตามลำดับการซื้อ
            history_list = [f"{i+1}. {entry['car']} - ${entry['price']}" 
                            for i, entry in enumerate(self.purchase_history)]
            history_str = "\n".join(history_list)

            # ใช้ Counter เพื่อเก็บจำนวนที่ขายของแต่ละรุ่น
            car_counts = Counter(entry['car'] for entry in self.purchase_history)

            # ใช้ defaultdict เพื่อเก็บยอดขายรวมแยกแต่ละรุ่น
            revenue_per_car = defaultdict(float)
            for entry in self.purchase_history:
                revenue_per_car[entry['car']] += entry['price']

            # สร้างข้อความเพื่อแสดงจำนวนและยอดขายรวมแยกแต่ละรุ่น
            counts_and_revenue_str = "\n".join([f"{car}: {count} sold, Total Revenue: ${revenue_per_car[car]:.2f}" 
                                                for car, count in car_counts.items()])

            total_sales = sum(entry['price'] for entry in self.purchase_history)
            total_cars_sold = len(self.purchase_history)  # จำนวนรถทั้งหมดที่ขาย

            # สร้างข้อความที่จะแสดงในกล่องข้อความ
            message = f"Purchase List:\n{history_str}\n\nCars Sold per Model:\n{counts_and_revenue_str}\n\nTotal Cars Sold: {total_cars_sold}\nTotal Sales: ${total_sales:.2f}"
            messagebox.showinfo("Purchase History", message)
        else:
            messagebox.showinfo("Purchase History", "No purchases have been made yet.")

if __name__ == "__main__":
    root = tk.Tk()
    app = VendingMachine(root)
    root.mainloop()
