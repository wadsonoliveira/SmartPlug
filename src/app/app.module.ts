import { NgModule } from '@angular/core';
import {
  MatButtonModule,
  MatListModule,
  MatSidenavModule
} from '@angular/material';
import { BrowserModule } from '@angular/platform-browser';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { MqttModule } from 'ngx-mqtt';
import { environment } from 'src/environments/environment';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { InfoComponent } from './info/info.component';
import { FlexLayoutModule } from '@angular/flex-layout';
import { LineChartModule } from '@swimlane/ngx-charts';

@NgModule({
  declarations: [AppComponent, InfoComponent],
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
    }),

    BrowserAnimationsModule,

    MatSidenavModule,
    MatButtonModule,
    MatListModule,

    FlexLayoutModule,

    LineChartModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule {}
