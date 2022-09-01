<style>
  table {
      border-collapse:collapse;
  }
  table, td, th {
    border: 1px solid silver;
    padding: 4px;
  }
  p code{
    border-radius: 6px;
    background: #d7d7d7;
    padding: 8px;
  }

  pre{
    border-radius: 6px;
    background: #d7d7d7;
    padding: 8px;
  }
</style>
# API Ticketbooking <a name="topo"></a>
- [Autenticação](#login_auth) 
- [Adicionar ou editar usuários](#usuarios_salvar) 
- [Listar ou pesquisar usuários](#usuarios_listar) 
- [Excluir um usuários](#usuarios_excluir) 
- [Adicionar ou editar pessoas](#usuarios_pessoa_salvar) 
- [Listar ou pesquisar pessoas](#usuarios_pessoa_listar) 
- [Excluir uma pessoa](#usuarios_pessoa_excluir) 
- [Adicionar ou editar endereços](#enderecos_salvar) 
- [Listar ou pesquisar endereços](#enderecos_listar) 
- [Excluir um endereço](#enderecos_excluir) 
- [Adicionar ou editar empresas](#empresas_salvar) 
- [Listar ou pesquisar empresas](#empresas_listar) 
- [Excluir um empresas](#empresas_excluir) 
- [Adicionar ou editar veiculos](#veiculos_salvar) 
- [Listar ou pesquisar veiculos](#veiculos_listar) 
- [Excluir ou pesquisar veiculos](#veiculos_excluir) 
- [Adicionar ou editar viagens](#viagens_salvar) 
- [Listar ou pesquisar viagens](#viagens_listar) 
- [Exluir uma viagens](#viagens_excluir) 



## Autenticação <a name="login_auth"></a>
[^ Topo](#topo) 

Faz autenticação de um usuário atravéz de usuario e senha e retorna os dados do usuário

### Bearer token
 Não

### Parâmetros
Parâmetros usados na requisição

| Parâmetro |Tipo     | Descrição        |
| --------- | ------- | ----------- | ---------------- |
| [usuario] | string  | Username |
| [senha]   | string  | Senha do usuário (Obrigatório com usuario e não necessária para email e celular  |
| [email]   | string  | E-mail de autenticação do usuário |
| [celular] | string  | Celular de autenticação do usuário |


### Request

`POST: {host}/users/login/auth`

```
{
	"usuario": "nome.usuarios",
	"senha": "senhaSecreta"
	"email": "email@exemplo.com"
	"celular": "99 99999-9999"
}
```
### Response
```
{
  "status": true,
  "msg": "Usuário não encontrado",
  "data": []
}
```
```
{
  "status": true,
  "msg": "Usuário autenticado",
  "data": [
    {
      "id": 1,
      "pessoa_id": 1,
      "usuario": "nome.usuario",
      "token": "VHJkUW84b05mVW55dD",
      "email": "email@exemplo.com",
      "celular": "449900000000",
      "nivel": 5,
    }
  ]
}
```
Ou

```
{
  "status": false,
  "msg": "Parâmetros incorretos. Usuario ou e-mail ou celar é obrigatório",
  "data": []
}
```



## Adicionar ou editar usuários <a name="usuarios_salvar"></a>
[^ Topo](#topo) 

Adiciona ou edita um usuário.
Se ID for passado na URL, faz a busca, caso encontre, faz a atualização dos dados.
Se ID não for passado na URL, faz a adição de um novo registro.


### Bearer token
 Sim

### Parâmetros
Parâmetros usados na requisição

| Parâmetro   | Tipo    | Descrição     |
| ----------- | ------ | ----------- | --------------|
| [usuario]   | string  | Username de um usuário |
| [senha]     | string  | Senha de um usuário. Senha será criptografada utilizando algoritmo sha256 |
| [email]     | string  | E-mail de autenticação de um usuário |
| [celular]   | string  | Celular de autenticação de um usuário |
| [pessoa_id] | string  | Id do cadastro da pessoa |
| [nivel]     | string  | Nivel do usuário: 1: Cliente; 2: Admim basico; 3: Admim super |

Obs: No retorno do usuário cadastrado trará o token de identificação deste usuário.


### Request

`POST: {host}/usuarios/salvar[/{id}]`

```
{
	"usuario": "nome.usuario",
  "senha": "senhaSecreta",
  "email":"email@exemplo.com",
  "celular":"99 99999-9999",
  "pessoa_id":"1",
  "nivel":"1"
}
```
### Response

```
{
  "status": true,
  "msg": "Usuario foi adicionado",
  "data": [
    {
      "id": 18,
      "pessoa_id": null,
      "usuario": "nome.usuario",
      "token": "cca7bda0ec635948f870577b5ab056d6e4062c164df4812c6cf7981d51101d64",
      "email": "email@exemplo.com",
      "celular": 99999999999
    }
  ]
}
``` 

Ou

```
{
  "status": false,
  "msg": "Já existe um usuário com esta identificação",
  "data": {
    "usuario": "nome.usuario",
    "email": "email@exemplo.com",
    "celular": "99999999999",
    "senha": "senhaSecreta",
    "token": "d577b0181bb73f3f139dee901dc6320459b99c69333a866933e1b744a8842f0a",
    "nivel": "1"
  }
}
```

Ou

```
{
  "status": false,
  "msg": "Parâmetros incorretos.",
  "data": null
}
```

## Listar ou pesquisar usuários <a name="usuarios_listar"></a>
[^ Topo](#topo) 

Busca um usuário por usuario, email ou celular.
Se não for enviado nenhum dos parâmetros no request, será retornado todos os usuários cadastrados,
porem se o Bearer token for de um usuário nível 1, filtrará só os dados do proprio usuário.

### Bearer token
 Sim

### Parâmetros
Parâmetros usados na requisição

| Parâmetro |Tipo     | Descrição     |
| --------- | ------ | ----------- | --------------|
| [usuario] | string  | Username de um usuário |
| [email]   | string  | E-mail de autenticação de um usuário |
| [celular] | string  | Celular de autenticação de um usuário |



### Request

`GET|POST: {host}/usuarios/listar`

```
{
	"usuario": "nome.usuario"
}
```

### Response

```
{
  "status": true,
  "msg": "0 usuário(s) encontrado(s)",
  "data": []
} 
```

Ou

```
{
  "status": true,
  "msg": "1 usuário(s) encontrado(s)",
  "data": [
    {
      "usuario": 1
      "pessoa_id": 1,
      "token": "VHJkUW84b05mVW55dD",
      "email": "emial@exemplo.com",
      "celular": "449900000000",
      "nivel": 1,
    }
  ]
}
```



## Excluir um usuário <a name="usuarios_excluir"></a>
[^ Topo](#topo) 

Busca um usuário pelo ID passado na URL e seta como excluído.
Usuários nível 1 não tem permissão para esta rota.

### Bearer token
 Sim

### Parâmetros

Nenhum parâmetro é enviado 


### Request

`GET|POST: {host}/usuarios/excluir/{id}`


### Response

```
{
  "status": false,
  "msg": "Não foi localizado",
  "data": []
}
```

Ou

```
{
  "status": true,
  "msg": "Foi excluído",
  "data": [
    {
      "id": 2,
      "excluido": "S",
      "excluido_por": 1,
      "data_excluido": "2022-07-26 17:01:55"
    }
  ]
}
```


## Adicionar ou editar pessoas <a name="usuarios_pessoa_salvar"></a>
[^ Topo](#topo) 

Adiciona ou edita uma pessoa.
Se ID for passado na URL, faz a busca, caso encontre, faz a atualização dos dados.
Se ID não for passado na URL, faz a adição de um novo registro.

### Bearer token
 Sim

### Parâmetros
Parâmetros usados na requisição

| Parâmetro       | Tipo   | Descrição |
| --------------- | ------ | -------------------------|
| [endereco_id]   | string | ID de um endereço cadastrado |
| nome          | string | Nome da pessoa |
| [cpf_cnpj]      | string | CPF ou CNPJ da pessoa  |
| [documento]     | string | Documento de identificação ou Inscrição estadual |
| [orgao_emissor] | string | Órgão emissor do documento de indentificação |


### Request

`POST: {host}/usuarios/pessoa/salvar`

```
    {
      "endereco_id": 1,
      "nome": "Nome da Pessoa",
      "cpf_cnpj": "12345678911",
      "natureza": "F",
      "documento": "1234567",
      "orgao_emissor": "SESP/PR"
    }
```

### Response

```
{
  "status": false,
  "msg": "Já existe um usuário com este CPF\/CNPJ",
  "data": {
    "endereco_id": 1,
    "nome": "Nome da Pessoa",
    "cpf_cnpj": "12345678910",
    "natureza": "F",
    "documento": "1234567",
    "orgao_emissor": "SESP\/PR"
  }
}
``` 

Ou

```
{
  "status": true,
  "msg": "Pessoa foi adicionado",
  "data": [
    {
      "id": 1,
      "endereco_id": 1,
      "nome": "Nome da Pessoa",
      "cpf_cnpj": "12345678910",
      "natureza": "F",
      "documento": "1234567",
      "orgao_emissor": "SESP\/PR"
    }
  ]
}
```



## Listar ou pesquisar pessoas <a name="usuarios_pessoa_listar"></a>
[^ Topo](#topo) 

Busca uma pessoa pelo nome, cpf_cnpj ou documento de indentificação.
Se não for enviado nenhum dos parâmetros no request, será retornado todos as pessoas cadastradas,
porem se o Bearer token for de um usuário nível 1, filtrará só os dados do proprio usuário.

### Bearer token
 Sim

### Parâmetros
Parâmetros usados na requisição

| Parâmetro   |Tipo     | Descrição     |
| ----------- | ------- | ----------- | --------------|
| [nome]      | string  | Nome de uma pessoa |
| [cpf_cnpj]  | string  | CPF/CNPJ de uma pessoa |
| [documento] | string  | Documento de identificação de uma pessoa |


### Request

`GET|POST: {host}/usuarios/pessoa/lista`


```
{
	"nome":"exemplo"
}

```

### Response

``` 
{
  "status": true,
  "msg": "2 usuário(s) encontrado(s)",
  "data": [
    {
      "id": 1,
      "endereco_id": null,
      "nome": "Nome da Pessoa",
      "cpf_cnpj": "12345678910",
      "natureza": null,
      "documento": null,
      "orgao_emissor": "2022-07-25 14:48:05"
    },
    {
      "id": 2,
      "endereco_id": null,
      "nome": "Exemplo de Nome de Pessoa",
      "cpf_cnpj": "36985214700",
      "natureza": null,
      "documento": null,
      "orgao_emissor": "2022-07-25 14:48:13"
    }
  ]
}
```

Ou

```
{
  "status": true,
  "msg": "1 usuário(s) encontrado(s)",
  "data": [
    {
      "id": 2,
      "endereco_id": null,
      "nome": "Exemplo de Nome de Pessoa",
      "cpf_cnpj": "36985214700",
      "natureza": null,
      "documento": null,
      "orgao_emissor": "2022-07-25 14:48:13"
    }
  ]
}
``` 

Ou

```
{
  "status": true,
  "msg": "0 usuário(s) encontrado(s)",
  "data": []
}
```


## Excluir uma pessoa <a name="usuarios_pessoa_excluir"></a>
[^ Topo](#topo) 

Busca uma pessoa pelo ID passado na URL e seta como excluído.
Usuários nível 1 não tem permissão para esta rota.

### Bearer token
 Sim

### Parâmetros

Nenhum parâmetro é enviado 


### Request

`GET|POST: {host}/usuarios/pessoa/excluir/{id}`


### Response

```
{
  "status": false,
  "msg": "Não foi localizado",
  "data": []
}
```

Ou

```
{
  "status": true,
  "msg": "Foi excluído",
  "data": [
    {
      "id": 2,
      "excluido": "S",
      "excluido_por": 1,
      "data_excluido": "2022-07-26 17:01:55"
    }
  ]
}
```



## Endereço/salvar <a name="enderecos_salvar"></a>
[^ Topo](#topo) 

Adiciona ou edita um endereço.
Se ID for passado na URL, faz a busca, caso encontre, faz a atualização dos dados.
Se ID não for passado na URL, faz a adição de um novo registro.
Usuário nível 1 não tem acesso a esta área.

### Bearer token
 Sim

### Parâmetros
Parâmetros usados na requisição

| Parâmetro       | Tipo   | Descrição |
| --------------- | ------ | -------------------------|
| cep   | string | ID de um endereço cadastrado |
| logradouro          | string | Nome da pessoa |
| [numero]      | string | CPF ou CNPJ da pessoa  |
| [complemento]     | string | Documento de identificação ou Inscrição estadual |
| cidade | string | Órgão emissor do documento de indentificação |
| [uf] | string | Órgão emissor do documento de indentificação |
| [pais] | string | Órgão emissor do documento de indentificação |


### Request

`POST: {host}/usuarios/pessoa/salvar[/{id}]`

```
{
  "cep":"88888-0000",
  "logradouro":"Rua Nome",
  "numero":"999",
  "complemento":"A",
  "uf":"UF",
  "cidade":"Nome da Cidade",
  "pais":"Brasil"
}
```

### Response

```
{
  "status": true,
  "msg": "Endereco foi adicionado",
  "data": [
    {
      "id": 2,
      "cep": 888880000,
      "logradouro": "Rua Nome",
      "numero": "999",
      "complemento": "A",
      "uf": "UF",
      "cidade": "Nome da Cidade",
      "pais": "Brasil",

    }
  ]
}
``` 

Ou

```
{
  "status": false,
  "msg": "Parâmetros incorretos.",
  "data": []
}
```




## Listar ou pesquisar endereços <a name="enderecos_listar"></a>
[^ Topo](#topo) 

Busca um endreço pelo cep, logradouro ou cidade
Se não for enviado nenhum dos parâmetros no request, será retornado todos os endereços cadastrados.
Usuário nível 1 não tem acesso a esta área.

### Bearer token
 Sim

### Parâmetros
Parâmetros usados na requisição

| Parâmetro |Tipo     | Descrição     |
| --------- | ------ | ----------- | --------------|
| [cep] | string  | Username de um usuário |
| [logradouro]   | string  | E-mail de autenticação de um usuário |
| [cidade] | string  | Celular de autenticação de um usuário |



### Request

`GET|POST: {host}/enderecos/listar`

```
{
 "logradouro": "Rua Nome",
}
```

### Response

```
{
  "status": true,
  "msg": "2 endereco(s) encontrado(s)",
  "data": [
    {
      "id": 1,
      "cep": 87033190,
      "logradouro": "Rua araxá",
      "numero": "987",
      "complemento": "",
      "uf": "PR",
      "cidade": "Maringá",
      "pais": "",
    },
    {
      "id": 2,
      "cep": 888880000,
      "logradouro": "Rua Nome",
      "numero": "999",
      "complemento": "A",
      "uf": "UF",
      "cidade": "Nome da Cidade",
      "pais": "Brasil",
    }
  ]
}
```





## Excluir um endereco <a name="enderecos_excluir"></a>
[^ Topo](#topo) 

Busca um endereço pelo ID passado na URL e seta como excluído.
Usuários nível 1 não tem permissão para esta rota.

### Bearer token
 Sim

### Parâmetros

Nenhum parâmetro é enviado 


### Request

`GET|POST: {host}/enderecos/excluir/{id}`


### Response

```
{
  "status": false,
  "msg": "Não foi localizado",
  "data": []
}
```

Ou

```
{
  "status": true,
  "msg": "Foi excluído",
  "data": [
    {
      "id": 2,
      "excluido": "S",
      "excluido_por": 1,
      "data_excluido": "2022-07-26 17:01:55"
    }
  ]
}
```

## Adicionar ou editar empresas <a name="empresas_salvar"></a>
[^ Topo](#topo) 

Adiciona ou edita um empreendimento.
Se ID for passado na URL, faz a busca, caso encontre, faz a atualização dos dados.
Usuário nível 1 não tem acesso a esta área.

### Bearer token
 Sim

### Parâmetros
Parâmetros usados na requisição

| Parâmetro     | Tipo    | Descrição     |
| ------------- | ------- | ----------- | --------------|
| [id]  | string  | ID de um empreendimento |
| [usuario_id]  | string  | ID de um usuário |
| [endereco_id] | string  | ID de um endereço |
| [nome]        | string  | Nome do empreendimento |


### Request

`POST: {host}/empresas/salvar[/{id}]`

```

{
  "usuario_id": "1",
  "endereco_id": "1",
  "nome": " casa exemplo "

}
```
### Response

```
{{
  "status": true,
  "msg": "Empresas foi salvo",
  "data": [
    {
      "id": 2,
      "usuario_id": 1,
      "endereco_id": 1,
      "nome": "Casa exemplo"
    }
  ]
}
```

Ou

```
{
  "status": false,
  "msg": "Parâmetros incorretos.",
  "data": null
}
```




## Listar ou pesquisar empresas <a name="empresas_listar"></a>
[^ Topo](#topo) 

Busca um empreendimento pelo nome, usupario_id ou endereco_id
Se não for enviado nenhum dos parâmetros no request, será retornado todos os empresas cadastrados,
Usuário nível 1 não tem acesso a esta área.

### Bearer token
 Sim

### Parâmetros
Parâmetros usados na requisição

| Parâmetro     | Tipo    | Descrição |
| ------------- | ------- | -------------------------|
| [nome]        | string  | Username de um usuário |
| [usupario_id] | string  | E-mail de autenticação de um usuário |
| [endereco_id] | string  | Celular de autenticação de um usuário |


### Request

`GET|POST: {host}/empresas/lista`

```
{
	"nome":"exemplo"
}

```

### Response

``` 
{
  "status": true,
  "msg": "2 empreendimento(s) encontrado(s)",
  "data": [
    {
      "id": 1,
      "usuario_id": 1,
      "endereco_id": 1,
      "nome": "Casa de teste"
    },
    {
      "id": 2,
      "usuario_id": 1,
      "endereco_id": 1,
      "nome": "Casa exemplo"
    }
  ]
}
```

Ou

``` 
{
  "status": true,
  "msg": "1 empreendimento(s) encontrado(s)",
  "data": [
    {
      "id": 2,
      "usuario_id": 1,
      "endereco_id": 1,
      "nome": "Casa exemplo"
    }
  ]
}
```

Ou

```
{
  "status": true,
  "msg": "0 empreendimento(s) encontrado(s)",
  "data": []
}
```


## Excluir um empreendimento <a name="empresas_excluir"></a>
[^ Topo](#topo) 

Busca um empreendimento pelo ID passado na URL e seta como excluído.
Usuários nível 1 não tem permissão para esta rota.

### Bearer token
 Sim

### Parâmetros

Nenhum parâmetro é enviado 


### Request

`POST: {host}/empresas/excluir/{id}`


### Response

```
{
  "status": false,
  "msg": "Não foi localizado",
  "data": []
}
```

Ou

```
{
  "status": true,
  "msg": "Foi excluído",
  "data": [
    {
      "id": 2,
      "excluido": "S",
      "excluido_por": 1,
      "data_excluido": "2022-07-26 17:01:55"
    }
  ]
}
```

## Adicionar ou editar veiculos <a name="veiculos_salvar"></a>
[^ Topo](#topo) 

Adiciona ou edita um veiculos.
Se ID for passado na URL, faz a busca, caso encontre, faz a atualização dos dados.
Usuário nível 1 não tem acesso a esta área.

### Bearer token
 Sim

### Parâmetros
Parâmetros usados na requisição

| Parâmetro     | Tipo    | Descrição     |
| ------------- | ------- | ----------- | --------------|
| [usuario_id]  | string  | ID de um usuário |
| [endereco_id] | string  | ID de um endereço |
| [nome]        | string  | Nome do empreendimento |


### Request

`POST: {host}/veiculos/salvar[/{id}]`

```
{
	"usuario_id": "1",
	"veiculos_tipo_id": 2,
	"emrpeendimento_id": 2,
	"nome":" exemplo  de     veiculos ",
	"marca": "Marca",
	"modelo": "M-1234"
}
```
### Response

```
{
  "status": true,
  "msg": "Veiculos foi adicionada",
  "data": [
    {
      "id": 4,
      "veiculos_tipo_id": 2,
      "usuario_id": 1,
      "nome": "Exemplo de veiculos",
      "marca": "Marca",
      "modelo": "M-1234"
    }
  ]
}
```

Ou

```
{
  "status": false,
  "msg": "Parâmetros incorretos.",
  "data": null
}
```




## Listar ou pesquisar veiculos<a name="veiculos_listar"></a>
[^ Topo](#topo) 

Busca um veiculos pelo nome, veiculos_tipo_id, usuario_id, marca ou modelo
Se não for enviado nenhum dos parâmetros no request, será retornado todos os veiculos cadastrados,
Porem se o Bearer token for de um usuário nível 1, filtrará só os dados do proprio usuário.

### Bearer token
 Sim

### Parâmetros
Parâmetros usados na requisição

| Parâmetro             |Tipo     | Descrição                |
| --------------------- | ------  | -------------------------|
| [veiculos_tipo_id] | string  | ID do tipo de veiculos |
| [usuario_id]          | string  | ID de um usuário |
| [nome]                | string  | Nome de um veiculos |
| [marca]               | string  | Marca de um veiculos |
| [modelo]              | string  | Modelo de um veiculos |


### Request

`GET|POST: {host}/veiculos/lista`

```
{
	"nome":"exemplo"
}

```

### Response

``` 
{
  "status": true,
  "msg": "2 veiculos(s) encontrado(s)",
  "data": [
    {
      "id": 1,
      "veiculos_tipo_id": 2,
      "usuario_id": 1,
      "nome": "Exemplo de veiculos",
      "marca": "Marca",
      "modelo": "M-1234"
    },
    {
      "id": 2,
      "veiculos_tipo_id": 2,
      "usuario_id": 1,
      "nome": "Nome de outro veiculos",
      "marca": "Marca",
      "modelo": "M-1234"
    }
  ]
}
```

Ou

```
{
  "status": true,
  "msg": "1 veiculos(s) encontrado(s)",
  "data": [
    {
      "id": 4,
      "veiculos_tipo_id": 2,
      "usuario_id": 1,
      "nome": "Exemplo de veiculos",
      "marca": "Marca",
      "modelo": "M-1234"
    }
  ]
}
``` 

Ou

```
{
  "status": true,
  "msg": "0 veiculos(s) encontrado(s)",
  "data": []
}
```

## Excluir um veiculos <a name="veiculos_excluir"></a>
[^ Topo](#topo) 

Busca um veiculos pelo ID passado na URL e seta como excluído.
Usuários nível 1 não tem permissão para esta rota.

### Bearer token
 Sim

### Parâmetros

Nenhum parâmetro é enviado 


### Request

`POST: {host}/veiculos/excluir/{id}`


### Response

```
{
  "status": false,
  "msg": "Não foi localizado",
  "data": []
}
```

Ou

```
{
  "status": true,
  "msg": "Foi excluído",
  "data": [
    {
      "id": 2,
      "excluido": "S",
      "excluido_por": 1,
      "data_excluido": "2022-07-26 17:01:55"
    }
  ]
}
```


## Veiculoss/tipo/salvar<a name="veiculos_tipo_salvar"></a>
[^ Topo](#topo) 

Adiciona ou edita um tipo de veiculos.
Se ID for passado na URL, faz a busca, caso encontre, faz a atualização dos dados.
Se ID não for passado na URL, faz a adição de um novo registro.


### Bearer token
 Sim

### Parâmetros
Parâmetros usados na requisição

| Parâmetro     | Tipo    | Descrição     |
| ------------- | ------- | -------------------------|
| [nome]        | string  | Nome do veiculos |
| [descricao]   | string  | Descrição de um tipo de veiculos |


### Request

`POST: {host}/veiculos/tipo/salvar[/{id}]`

```
{
	"nome": "Exemplo",
	"descricao": "Descrição do exemplo"
}
```
### Response

```
{
  "status": true,
  "msg": "Veiculos foi adicionada",
  "data": [
    {
      "id": 8,
      "veiculos_tipo_id": 2,
      "usuario_id": 1,
      "nome": "Iluminação da sala",
      "marca": "Philipps",
      "modelo": "PH-2596",
      "excluido": "N",
      "excluido_por": null,
      "data_excluido": null,
      "data_insert": "2022-07-18 15:45:05",
      "data_update": null
    }
  ]
}
```

Ou

```
{
  "status": false,
  "msg": "Parâmetros incorretos.",
  "data": null
}
```



## Veiculoss/tipo/listar<a name="veiculos_tipo_listar"></a>
[^ Topo](#topo) 

Busca um tipo de veiculos, nome ou descricao
Se não for enviado nenhum dos parâmetros no request, será retornado todos os usuários cadastrados,
Porem se o Bearer token for de um usuário nível 1, filtrará só os dados do proprio usuário.

### Bearer token
 Sim

### Parâmetros
Parâmetros usados na requisição

| Parâmetro             |Tipo     | Descrição                |
| --------------------- | ------  | -------------------------|
| [nome]                | string  | Nome de um tipo de veiculos |
| [descricao]          | string  | Descrição de um tipo de veiculos |


### Request

`GET|POST: {host}/veiculos/tipo/lista`

```
{
	"nome":"exemplo"
}

```

### Response

``` 
{
  "status": true,
  "msg": "2 tipo(s) de veiculos(s) encontrado(s)",
  "data": [
    {
      "id": 12,
      "nome": "Exemplode Tipo",
      "descricao": "Descrição do exemplo"
    },
    {
      "id": 13,
      "nome": "Nome do Tipo",
      "descricao": "Descrição do tipo"
    }
  ]
}
```

Ou

```
{
  "status": true,
  "msg": "1 tipo(s) de veiculos(s) encontrado(s)",
  "data": [
    {
      "id": 12,
      "nome": "Exemplode Tipo",
      "descricao": "Descrição do exemplo"
    }
  ]
}
``` 

Ou

```
{
  "status": true,
  "msg": "0 tipo(s) de veiculos(s) encontrado(s)",
  "data": []
}
```

## Excluir um tipo de veiculos <a name="veiculos_tipo_excluir"></a>
[^ Topo](#topo) 

Busca um tipo de veiculos pelo ID passado na URL e seta como excluído.
Usuários nível 1 não tem permissão para esta rota.

### Bearer token
 Sim

### Parâmetros

Nenhum parâmetro é enviado 


### Request

`POST: {host}/veiculos/tipo/excluir/{id}`


### Response

```
{
  "status": false,
  "msg": "Não foi localizado",
  "data": []
}
```

Ou

```
{
  "status": true,
  "msg": "Foi excluído",
  "data": [
    {
      "id": 2,
      "excluido": "S",
      "excluido_por": 1,
      "data_excluido": "2022-07-26 17:01:55"
    }
  ]
}
```



## Adicionar ou editar viagens<a name="viagens_salvar"></a>
[^ Topo](#topo) 

Adiciona ou edita uma cena.
Se ID for passado na URL, faz a busca, caso encontre, faz a atualização dos dados.
Se ID não for passado na URL, faz a adição de um novo registro.

### Bearer token
 Sim

### Parâmetros
Parâmetros usados na requisição

| Parâmetro       | Tipo    | Descrição     |
| --------------- | ------- | ----------- | --------------|
| [usuario_id]    | string  | ID de um usuário |
| [nome]          | string  | ID de um endereço |
| [configuracoes] | string  | Json com as configurações de uma cena |


### Request

`POST: {host}/viagens/salvar[/{id}]`

```
{
	"usuario_id": "1",
	"nome":"Sala de star",
	"configuracoes": [
		{
			"veiculos_id": 1,
			"state": 1,
			"bright": 80
		},
		{
		"veiculos_id": 2,
			"state": 1,
			"bright": 50
		},
		{
			"veiculos_id": 3,
			"state": 0
		},
		{
		  "veiculos_id": 4,
			"stare": 1,
			"teperatura": 23,
			"speed": 4
		}
	]

}
```
### Response

```
{
  "status": true,
  "msg": "Cenas foi salva",
  "data": [
    {
      "id": 2,
      "usuario_id": 1,
      "nome": "Exemplo de cena",
      "configuracoes": "[{\"state\": 1, \"bright\": 80, \"veiculos_id\": 1}, {\"state\": 1, \"bright\": 50, \"veiculos_id\": 2}, {\"state\": 0, \"veiculos_id\": 3}, {\"speed\": 4, \"stare\": 1, \"teperatura\": 23, \"veiculos_id\": 4}]",
      "excluido": "N",
      "excluido_por": null,
      "data_excluido": null,
      "data_insert": "2022-07-18 09:29:45",
      "data_update": "2022-07-25 17:08:01"
    }
  ]
}
```

Ou

```
{
  "status": false,
  "msg": "Parâmetros incorretos.",
  "data": null
}
```


## Listar ou pesquisar viagens<a name="viagens_listar"></a>
[^ Topo](#topo) 

Busca uma cena pelo nome ou usuario_id.
Se não for enviado nenhum dos parâmetros no request, será retornado todos as viagens cadastrados,
Porem se o Bearer token for de um usuário nível 1, filtrará só os dados do proprio usuário.

### Bearer token
 Sim

### Parâmetros
Parâmetros usados na requisição

| Parâmetro             |Tipo     | Descrição                |
| --------------------- | ------  | -------------------------|
| [usuario_id]          | string  | ID de um usuário |
| [nome]                | string  | Nome de um veiculos |


### Request

`GET|POST: {host}/viagens/lista`

```
{
	"nome":"exemplo"
}

```

### Response

``` 
{
  "status": true,
  "msg": "2 viagens(s) encontrado(s)",
  "data": [
    {
      "id": 1,
      "usuario_id": 1,
      "nome": "Exemplo de cena",
      "configuracoes": "[{\"state\": 1, \"bright\": 80, \"veiculos_id\": 1}, {\"state\": 1, \"bright\": 50, \"veiculos_id\": 2}, {\"state\": 0, \"veiculos_id\": 3}, {\"speed\": 4, \"stare\": 1, \"teperatura\": 23, \"veiculos_id\": 4}]",
      "excluido": "N",
      "excluido_por": null,
      "data_excluido": null,
      "data_insert": "2022-07-18 09:29:45",
      "data_update": "2022-07-25 17:09:27"
    },
    {
      "id": 2,
      "usuario_id": 1,
      "nome": "Teste de cena",
      "configuracoes": "[{\"state\": 1, \"bright\": 80, \"veiculos_id\": 1}, {\"state\": 1, \"bright\": 50, \"veiculos_id\": 2}, {\"state\": 0, \"veiculos_id\": 3}, {\"speed\": 4, \"stare\": 1, \"teperatura\": 23, \"veiculos_id\": 4}]",
      "excluido": "N",
      "excluido_por": null,
      "data_excluido": null,
      "data_insert": "2022-07-25 17:09:13",
      "data_update": "2022-07-25 17:09:28"
    }
  ]
}
```

Ou

```
{
  "status": true,
  "msg": "1 viagens(s) encontrado(s)",
  "data": [
    {
      "id": 1,
      "usuario_id": 1,
      "nome": "Exemplo de cena",
      "configuracoes": "[{\"state\": 1, \"bright\": 80, \"veiculos_id\": 1}, {\"state\": 1, \"bright\": 50, \"veiculos_id\": 2}, {\"state\": 0, \"veiculos_id\": 3}, {\"speed\": 4, \"stare\": 1, \"teperatura\": 23, \"veiculos_id\": 4}]",
      "excluido": "N",
      "excluido_por": null,
      "data_excluido": null,
      "data_insert": "2022-07-18 09:29:45",
      "data_update": "2022-07-25 17:09:27"
    }
  ]
}
``` 

Ou

```
{
  "status": true,
  "msg": "0 empreendimento(s) encontrado(s)",
  "data": []
}
```

## Excluir uma cena <a name="viagens_excluir"></a>
[^ Topo](#topo) 

Busca uma cena pelo ID passado na URL e seta como excluído.
Usuários nível 1 não tem permissão para esta rota.

### Bearer token
 Sim

### Parâmetros

Nenhum parâmetro é enviado 


### Request

`POST: {host}/viagens/excluir/{id}`


### Response

```
{
  "status": false,
  "msg": "Não foi localizado",
  "data": []
}
```

Ou

```
{
  "status": true,
  "msg": "Foi excluído",
  "data": [
    {
      "id": 2,
      "excluido": "S",
      "excluido_por": 1,
      "data_excluido": "2022-07-26 17:01:55"
    }
  ]
}
```

