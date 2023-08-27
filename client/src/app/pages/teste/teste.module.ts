import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { TesteRoutingModule } from './teste-routing.module';
import { ComponenteTesteComponent } from './componente-teste/componente-teste.component';
import { NbCardModule, NbIconModule, NbInputModule, NbTreeGridModule } from '@nebular/theme';
import { ThemeModule } from '../../@theme/theme.module';
import { TablesRoutingModule } from '../tables/tables-routing.module';
import { Ng2SmartTableModule } from 'ng2-smart-table';


@NgModule({
  declarations: [
    ComponenteTesteComponent
  ],
  imports: [
    CommonModule,
    TesteRoutingModule,
    NbCardModule,
    NbTreeGridModule,
    NbIconModule,
    NbInputModule,
    ThemeModule,
    TablesRoutingModule,
    Ng2SmartTableModule,
  ]
})
export class TesteModule { }
