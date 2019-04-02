import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { MqttModule } from 'ngx-mqtt';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { environment } from 'src/environments/environment';

@NgModule({
  declarations: [AppComponent],
  imports: [
    BrowserModule,
    AppRoutingModule,
    MqttModule.forRoot({
      host: environment.mqtt.server,
      hostname: environment.mqtt.server,
      port: environment.mqtt.port,
      password: environment.mqtt.password,
      username: environment.mqtt.username,
      protocol: 'wss'
    })
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule {}
