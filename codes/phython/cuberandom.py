import turtle
import random
colors=["red","magenta","blue","yellow","black","green","pink","orange","violet"]
j = random.randint(2,5)
turtle.color(colors[j])
turtle.penup()
turtle.setposition(0,0)
turtle.pendown()

for i in range(4):
    turtle.color(colors[j])
    turtle.fd(150)
    turtle.left(90)

turtle.left(45)
turtle.color(colors[j])
turtle.fd(106.38)
turtle.right(45)

for i in range(4):
    turtle.color(colors[j+4])
    turtle.fd(150)
    turtle.left(90)

turtle.color(colors[j+1])
turtle.fd(150)
turtle.right(135)
turtle.color(colors[j-1])
turtle.fd(106.38)
turtle.right(135)
turtle.color(colors[j+2])
turtle.fd(150)
turtle.right(45)
turtle.color(colors[j-2])
turtle.fd(106.38)
turtle.left(135)
turtle.color(colors[j-3])
turtle.fd(150)
turtle.left(45)
turtle.color(colors[j+3])
turtle.fd(106.38)
