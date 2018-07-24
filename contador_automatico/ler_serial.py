import serial

ARDUINO = 'dev/ttyUSB0'
PORTA = '9600'


test = serial.Serial(ARDUINO, PORTA)

ler = test.read()

print ler

test.close()
