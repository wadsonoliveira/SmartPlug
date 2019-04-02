import { Component, OnDestroy } from '@angular/core';
import { IMqttMessage, MqttService } from 'ngx-mqtt';
import { Subscription } from 'rxjs';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnDestroy {
  title = 'SmartPlug';

  private subscription: Subscription;
  message: string;

  constructor(private mqttService: MqttService) {
    this.subscription = this.mqttService
      .observe('hello')
      .subscribe((message: IMqttMessage) => {
        console.log('testing');

        this.message = message.payload.toString();
      });

    this.mqttService.onConnect.subscribe(test => console.log('gogogo'));
    this.mqttService.onError.subscribe(msg => console.log(msg));
  }

  unsafePublish(topic: string, message: string): void {
    this.mqttService.unsafePublish(topic, message, { qos: 1, retain: true });
  }

  ngOnDestroy() {
    this.subscription.unsubscribe();
  }
}
