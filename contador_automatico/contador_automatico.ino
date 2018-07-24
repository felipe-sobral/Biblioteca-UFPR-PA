int valorSensor = 0;
int ativoMarrom = 0;
int ativoPreto = 0;
int contador = 0;

void setup() {
  Serial.begin(9600);
}

void verificaSensor(int sensor, int id){
  if(sensor > 1015){
    if(id == 1){
      
      if(ativoPreto != 1 || ativoPreto == 0){
        ativoMarrom = 1;
      } else {
        ativoMarrom = 2;
      }

      Serial.println("ENTROU AQUI");
      
    } else if(id == 2){

      if(ativoMarrom != 1 || ativoMarrom == 0){
        ativoPreto = 1;    
      } else {
        ativoPreto = 2;
      }

      Serial.println("ENTROU AQUI2");
    }
  }

  while(sensor > 1015){
    if(id==1){
      sensor = analogRead(A1);
    } else if(id==2){
      sensor = analogRead(A2);
    }
    delay(100);
  }

  Serial.println("SAIU");
}

void verificaCaso(){
  Serial.println("ENTROU AQUI3");
  if(ativoMarrom == 1 && ativoPreto == 2){
    contador++;
  } else if(contador > 0){
    contador--;
  }

  ativoMarrom = 0;
  ativoPreto = 0;
}

void loop() {
  /*
   * 1023 (Se maior que 1020, sensor ATIVADO; se menor que 1020, sensor DESATIVADO)
   * Sensor Marrom = PRIMEIRO SENSOR
   * Sensor Preto = SEGUNDO SENSOR
   */
  int sensorMarrom = analogRead(A1);
  int sensorPreto = analogRead(A2);
  verificaSensor(sensorMarrom, 1);
  verificaSensor(sensorPreto, 2);

  Serial.println(ativoMarrom);
  Serial.println(ativoPreto);

  if(ativoMarrom != 0 && ativoPreto != 0){
    verificaCaso();
  }

 
  Serial.println(contador);
  
  /*if(valorSensor > 1020){
    Serial.println("ALGO NA FRENTE!!!");
  }else{
    Serial.println("NADA NA FRENTE");
  }*/
  delay(100);
}
