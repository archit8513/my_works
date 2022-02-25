# A firday speak program or softwer
 #import modules


#import win32api

from pyautogui import *
import pyautogui
import keyboard
from selenium import webdriver

import pyttsx3
import datetime 
import speech_recognition as sr
import os
import wikipedia
import webbrowser
import time 
import random
import pyaudio

"""
print(" A FRIDAY 2.0")
#using voices of windows
engine = pyttsx3.init("sapi5")
voices = engine.getProperty('voices')
#print(voices[1].id)


engine.setProperty('voice', voices[1].id)



#a speak function who speak as user told to speak.
def speak(audio):
    
    engine.say(audio)
    engine.runAndWait()
"""
def shoping():
    product=input("enter product name : ")
    brand = input("enter brand name for product: ")
    e_com_web = input("enter website for serch product: ")
    PATH = 'C:/Apps/chromedriver_win32/chromedriver.exe'
    drive = webdriver.Chrome(PATH)
    drive.get("https://www.amazon.in/?ie=UTF8&ext_vrnc=hi&tag=googhydrabk-21&ascsubtag=_k_Cj0KCQjw4eaJBhDMARIsANhrQAC34hlP829gf4pnnbxs7x0NfuBMfvwOeeIkU1ucRBTbry7UFV0DnBcaAuQfEALw_wcB_k_&ext_vrnc=hi&gclid=Cj0KCQjw4eaJBhDMARIsANhrQAC34hlP829gf4pnnbxs7x0NfuBMfvwOeeIkU1ucRBTbry7UFV0DnBcaAuQfEALw_wcB")
    time.sleep(2)
    pyautogui.press("alt" "space" "x")
    button = drive.find_element_by_class_name("nav-search-field")
    button.click()
    keyboard.write(brand+" "+product)
    pyautogui.press("enter")
    pyautogui.moveTo(100, 100, duration = 0.1)
    pyautogui.press("enter")

    
"""    
def insta_login():
    userid= input("enter your instragram user id: ")        
    password= input("enter your instragram password:")
    time.sleep(1)
    PATH = 'C:/Apps/chromedriver_win32/chromedriver.exe'
    drive = webdriver.Chrome(PATH)
    drive.get("https://www.instagram.com/")
    time.sleep(2)
    pyautogui.press("tab")    
    time.sleep(1)
    keyboard.write(userid)
    pyautogui.press("tab")
    keyboard.write(password)
    button = drive.find_element_by_class_name("Igw0E.IwRSH.eGOV_._4EzTm.bkEs3.CovQj.jKUp7.DhRcB")
    button.click()    
        


def insta_dm():
    name_dm = input("enter name to dm: ")
    massges = input("dm : ")
    userid= input("enter your instragram user id: ")        
    password= input("enter your instragram password:")
    time.sleep(1)
    PATH = 'C:/Apps/chromedriver_win32/chromedriver.exe'
    drive = webdriver.Chrome(PATH)
    drive.get("https://www.instagram.com/")
    time.sleep(2)
    pyautogui.press("tab")    
    time.sleep(1)
    keyboard.write(userid)
    pyautogui.press("tab")
    keyboard.write(password)
    button = drive.find_element_by_class_name("Igw0E.IwRSH.eGOV_._4EzTm.bkEs3.CovQj.jKUp7.DhRcB")
    button.click()    
        
    
    time.sleep(5)

    
    button = drive.find_element_by_class_name("xWeGp")
    button.click()
    time.sleep(2)
    button = drive.find_element_by_class_name("aOOlW.HoLwm ")
    button.click()    
    time.sleep(1)
    button = drive.find_element_by_class_name("LWmhU._0aCwM")
    button.click()    
    time.sleep(1)
    keyboard.write(name_dm)
    time.sleep(2)
    button = drive.find_element_by_class_name("-qQT3")                                                                                                                      
    button.click()
    time.sleep(2)
    button = drive.find_element_by_class_name("sqdOP.L3NKy._8A5w5")
    button.click()
    time.sleep(2)
   # keyboard.write(massges)
    #time.sleep(1)
    #send button
    button = drive.find_element_by_class_name("wpO6b")
    button.click()
  

def facebook():
    userid= input("enter your facebook user id: ")        
    password= input("enter your facebook password:")
    time.sleep(1)
    PATH = 'C:/Apps/chromedriver_win32/chromedriver.exe'
    drive = webdriver.Chrome(PATH)
    drive.get("https://touch.facebook.com/")
    time.sleep(2)
    button = drive.find_element_by_class_name("_96n9")
    button.click()    
    time.sleep(1)
    keyboard.write(userid)
    pyautogui.press("tab")
    keyboard.write(password)
    button = drive.find_element_by_class_name("_54k8._52jh._56bs._56b_._28lf._9cow._56bw._56bu")
    button.click()
    time.sleep(1)
    button = drive.find_element_by_class_name("_54k8._56bs._26vk._56b_._56bw._56bu")
    button.click()  
  
#wishme function who whish user as per time in user's pc    
def wishme():
    
    hour=int(datetime.datetime.now().hour)
    
   
    if hour>=0 and hour<12 :
            speak("good morning ")
            #print("good morning ")

           
    elif hour>=12 and hour<16:
            
            speak("good after noon ")
            #print("good after noon ")

    elif hour>=16 and hour<=19:
            
            speak("GOOD  evening ")
            #print("good   evening ")        
    else :
            speak("good night")
            #print("good night")
           
    speak(" hello i am friday , how can i help you")        

# a teke command who take commands from user 
def takecommand():

#recognizing function who recogniz what user said and give commant to for this program
    r =  sr.Recognizer()
    with sr.Microphone() as source:
        print(" listening.......")
        r.pause_threshold = 1
        r.energy_threshold = 800
        audio = r.listen(source)
       

    try:
        print("recognizing......")
        
        query = r.recognize_google(audio, language ='en-in')
        #query = input("what do you search")
        print("usar said : " , query)
        #speak("usar said :", query)
        
        

       
# if softwer does'n get your command properly so try function help for that

    except Exception as e:
        #print(e)

        print("say that again please.....")
        return "none"
    
    return query
        
       



if __name__ == "__main__":
    wishme()
    
    
  #while loop for continus listing so that program or softwer take command from user many time befor it stop  
    while True:
        query = takecommand().lower()
        #query=input("what you wan: ")
        if 'wikipedia' in query:
            speak("serching wikipedia...")
            query = query.replace("wikipedia", "")
            resualt =  wikipedia.summary(query, sentences=2)
            
            print(resualt)
    
            speak(resualt)
# some functions who make this program so intresting for user           
        elif 'open youtube' in query:
            webbrowser.open("youtube.com")

        elif 'open google'  in query:
            webbrowser.open("google.com")
            
        elif 'open chrome'  in query:
            webbrowser.open("C:/Users/Public/Desktop/Google Chrome.lnk")
            
        elif 'open visual studio code'  in query:
            webbrowser.open("C:/Users/Archit/Desktop/Visual Studio Code.lnk")
            
        elif 'open mirzapur' in query:
            webbrowser.open("D:/movies/mirzapur")
            
        elif 'open scam' in query:
            webbrowser.open("D:/movies/sacme 1992")
            
        elif 'open harry potter' in query:
            webbrowser.open("G:/aArchit's/archit's movis/ALL PARTS OF HARRY POTTER")
            
        elif 'tell me about your developer' in query:
            print("this is a friday verstion 2.0, this is design by A.R. ")  
            speak("this is a friday verstion 2.0, this is design by A.R. ")
            
            
        elif 'play music' in query:
            random_songs = random.randint(0, 10)
            song = "E:/amitabh song/01 MUQANDAR KA SIKANDAR = [1978] AMITABH & RAKHEE"
            songs = os.listdir(song)
            #print(songs)
            os.startfile(os.path.join(song, songs[random_songs]))
            break

        elif 'the time' in query:
            strTime = datetime.datetime.now().strftime("%H,%M,%S")
            speak(strTime)
            print(strTime)

        elif 'quit' in query:
            break

        elif 'instagram login' in query:   
            insta_login()
            break

        elif 'hello' in query:
            insta_dm()
            break
        
        elif 'facebook' in query:
            facebook()
            break
            
        elif 'shopping' in query:
            shoping()
            break
        
        else:
            PATH = 'C:/Apps/chromedriver_win32/chromedriver.exe'
            drive = webdriver.Chrome(PATH)
            drive.get("https://www.google.com/")
            time.sleep(1)
            keyboard.write(query)
            time.sleep(2)
            pyautogui.press("enter")
            button = drive.find_element_by_class_name("gLFyf.gsfi")
            break
                
    takecommand()    
 """
        
    
shoping()                     
                     

        
    


