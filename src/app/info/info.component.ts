import { Component } from '@angular/core';
import { IMqttMessage, MqttService } from 'ngx-mqtt';
import { Subscription } from 'rxjs';

const a = [
  {
    name: 'Corrente',
    series: [
      {
        name: '22:51',
        value: 1.5
      },
      {
        name: '22:52',
        value: 2.0
      }
    ]
  },

  {
    name: 'Potência',
    series: [
      {
        name: '22:51',
        value: 3.0
      },
      {
        name: '22:52',
        value: 3.2
      }
    ]
  }
];

@Component({
  selector: 'app-info',
  templateUrl: './info.component.html',
  styleUrls: ['./info.component.scss']
})
export class InfoComponent {
  private subscription: Subscription;
  message: string;
  isTurnedOn: boolean;

  data: any[] = a;

  constructor(private mqttService: MqttService) {
    this.subscription = this.mqttService
      .observe('LED')
      .subscribe((message: IMqttMessage) => {
        console.log('testing');
        this.message = message.payload.toString();
      });

    this.mqttService.observe('I1').subscribe((message: IMqttMessage) => {
      this.message = message.payload.toString();
      console.log(this.message);
    });

    this.mqttService.onConnect.subscribe(test => console.log('gogogo'));
    this.mqttService.onError.subscribe(msg => console.log(msg));
    this.isTurnedOn = true;
  }

  toggleLed() {
    if (this.isTurnedOn) {
      this.mqttService.publish('LED', 'L1').subscribe(() => {});
    } else {
      this.mqttService.publish('LED', 'D1').subscribe(() => {});
    }
    this.isTurnedOn = !this.isTurnedOn;
  }

  unsafePublish(topic: string, message: string): void {
    this.mqttService.unsafePublish(topic, message, { qos: 1, retain: true });
  }

  ngOnDestroy() {
    this.subscription.unsubscribe();
  }
}
