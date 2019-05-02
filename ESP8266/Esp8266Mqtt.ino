#include <ESP8266WiFi.h>
#include <PubSubClient.h> 
#define DEBUG
#define INTERVALO_ENVIO 1000

//Dados de conexão com a rede WiFi e com o CloudMQTT
const char* ssid = "Abmael&Raimunda"; 
const char* password = "Natal.2019";
const char* mqttServer = "m15.cloudmqtt.com"; 
const int mqttPort = 17999; 
const char* mqttUser = "tlxgjowo"; 
const char* mqttPassword = "x1zhXkwOn75L"; 
const char* mqttTopicSub ="xxxxxxx";

float vetCorrente[300];
char MsgCorrenteMQTT[10];
char MsgPotenciaMQTT[10];
int ultimoEnvioMQTT = 0;
const int LED1 = LED_BUILTIN;

WiFiClient espClient;
PubSubClient client (espClient);

void mqtt_callback (char* topic, byte* dados_tcp, unsigned int length);

void setup () { 
  pinMode (LED1, OUTPUT);
  pinMode(17, INPUT);
  
  Serial.begin (115200);
  WiFi.begin (ssid, password);

  while (WiFi.status() != WL_CONNECTED) 
  {   
    delay(100);
    Serial.println("Conectando um WiFi ..");
  }
  Serial.println("Conectado!"); 
  client.setServer (mqttServer, mqttPort);
  client.setCallback (callback);
 
  while (!client.connected()) {
    Serial.println ("Conectando ao servidor MQTT ...");
    
    if (client.connect ("Projeto", mqttUser, mqttPassword))
    {
 
      Serial.println ("Conectado ao servidor MQTT!");  
 
    }else{
 
      Serial.print ("Falha ao conectar ");
      Serial.print (client.state());
      delay(2000);
 
    }
  }
 
  client.publish ("Status", "Reiniciado!");
  client.publish ("Placa", "Em funcionamento!");
  client.subscribe ("LED"); 
  client.subscribe (mqttTopicSub);
}

void reconect() {
  
  //Enquanto estiver desconectado
  
  while (!client.connected()) {
    #ifdef DEBUG
    Serial.print("Tentando conectar ao servidor MQTT");
    #endif
     
    bool conectado = strlen(mqttUser) > 0 ?
                     client.connect("ESP8266Client", mqttUser, mqttPassword) :
                     client.connect("ESP8266Client");
 
    if(conectado) {
      #ifdef DEBUG
      Serial.println("Conectado!");
      #endif
      
      //subscreve no tópico
      
      client.subscribe(mqttTopicSub, 1); //nivel de qualidade: QoS 1
      client.subscribe("LED",1);
    } else {
                  
      #ifdef DEBUG
      Serial.println("Falha durante a conexão.Code: ");
      Serial.println( String(client.state()).c_str());
      Serial.println("Tentando novamente em 10 s");
      #endif
      
      //Aguarda 10 segundos
       
      delay(10000);
    }
  }
}

void callback (char * topic, byte * dados_tcp, unsigned int length) {
    for(int i=0; i < length; i++) {
      }
  if ((char)dados_tcp[0] == 'L' && (char)dados_tcp[1] == '1') {
    digitalWrite(LED1, HIGH);   
  } else if ((char)dados_tcp[0] == 'D' && (char)dados_tcp[1] == '1') {
    digitalWrite(LED1, LOW);  
  }
} 

float informations(){
  double maior_Valor = 0;
  double valor_Corrente = 0;  
 
  float tensao = 127;
  float potencia = 0;
 
  for(int i = 0; i < 300; i++)
  {
    vetCorrente[i] = analogRead(17);
    delayMicroseconds(600);
  }  
 
  for(int i = 0; i < 300; i++)
  {
    if(maior_Valor < vetCorrente[i])
    {
      maior_Valor = vetCorrente[i];
    }
  }  
 
  maior_Valor = maior_Valor * 0.004882812;
  valor_Corrente = maior_Valor - 2.5;
  valor_Corrente = valor_Corrente * 1000;
  valor_Corrente = valor_Corrente / 185;         //sensibilidade : 66mV/A para ACS712 30A / 185mV/A para ACS712 5A
  valor_Corrente = valor_Corrente / 1.41421356;
 
  Serial.print("Corrente = ");
  sprintf(MsgCorrenteMQTT,"%f",valor_Corrente);
  client.publish("Corrente", MsgCorrenteMQTT);
  Serial.println(" A");
 
  potencia = valor_Corrente * tensao;
  Serial.print("Potencia = ");
  sprintf(MsgPotenciaMQTT,"%f",potencia);
  client.publish("Potência", MsgPotenciaMQTT);
  Serial.println(" W");
  
  Serial.print(".");
  delay(500);
  Serial.print(".");
  delay(500);
  Serial.print(".");
  delay(500);
  Serial.println("");
  float dados[2];
  dados[0]= valor_Corrente;
  dados[1]= potencia;
  return dados[2];
  }

void loop () {    
    if (!client.connected()) {
    reconect();
  }
  //envia a cada X segundos
  if ((millis() - ultimoEnvioMQTT) > INTERVALO_ENVIO)
  {
      informations();
      ultimoEnvioMQTT = millis();
  }     
    client.loop ();
    informations();
 }
