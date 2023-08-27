import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ComponenteTesteComponent } from './componente-teste/componente-teste.component';

const routes: Routes = [
  {
    path: '',
    component: ComponenteTesteComponent
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class TesteRoutingModule { }
