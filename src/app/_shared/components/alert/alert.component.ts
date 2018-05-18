import { Component, OnInit } from '@angular/core';

import { Alert, AlertType } from './../../../_models';
import { AlertService } from './alert.service';

@Component({
    moduleId: module.id,
    selector: 'app-alert',
    templateUrl: 'alert.component.html',
    styleUrls: ['./alert.component.scss']
})

export class AlertComponent {
    // array de alertas
    alerts: Alert[] = [];

    constructor(private alertService: AlertService) { }

    ngOnInit() {
        this.alertService.getAlert().subscribe((alert: Alert) => {
            if (!alert) {
                // Limpe alertas quando um alerta vazio é recebido
                this.alerts = [];
                return;
            }

            // adicionar alerta no array
            this.alerts.push(alert);
            this.timer(alert);
        });
    }

    removeAlert(alert: Alert) {
        this.alerts = this.alerts.filter(x => x !== alert);
    }

    cssClass(alert: Alert) {
        if (!alert) {
            return;
        }

        // retorna a classe css de acordo com o type do alert
        switch (alert.type) {
            case AlertType.Success:
                return 'alert alert-success animated fadeInUp';
            case AlertType.Error:
                return 'alert alert-danger animated fadeInUp';
            case AlertType.Info:
                return 'alert alert-info animated fadeInUp';
            case AlertType.Warning:
                return 'alert alert-warning animated fadeInUp';
        }

    }

    timer(alert: Alert){
        setInterval(()=>{
            this.alerts = this.alerts.filter(x => x !== alert);
        }, 5000);        
    }
}