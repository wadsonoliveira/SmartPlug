# SmartPlug
Autor: José Wadson Oliveira Silva - Engenheiro da Computação - Universidade Federal do Rio Grande do Norte - UFRN.
Este projeto visa desenvolver uma tomada inteligente utilizando o NodeMCU1.0(ESP12-E) juntamente com um broker MQTT através de uma aplicação Web em PHP. Para tanto, utilizou a biblioteca phpMQTT (Source: http://github.com/bluerhinos/phpMQTT) bem como o CloudMQTT (https://www.cloudmqtt.com/).
Utilizou-se ainda um sensor de corrente ACS712 a fim de se plotar na aplicação Web os gráficos de corrente e de potência. A aplicação conta ainda com a parte de agendamentos utilizando o FullCalendar (https://fullcalendar.io/) a fim de poder se fazer agendamentos do funcionamento da carga elétrica a que se está conectada à tomada inteligente.
O sistema foi desenvolvido no ambiente Windows, Apache, Mysql, PHP - WAMP.
