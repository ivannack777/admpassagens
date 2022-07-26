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
# API Automação <a name="topo"></a>
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
- [Adicionar ou editar empreendimentos](#empreendimentos_salvar) 
- [Listar ou pesquisar empreendimentos](#empreendimentos_listar) 
- [Excluir um empreendimentos](#empreendimentos_excluir) 
- [Adicionar ou editar dispositivos](#dispositivos_salvar) 
- [Listar ou pesquisar dispositivos](#dispositivos_listar) 
- [Excluir ou pesquisar dispositivos](#dispositivos_excluir) 
- [Adicionar ou editar cenas](#cenas_salvar) 
- [Listar ou pesquisar cenas](#cenas_listar) 
- [Exluir uma cenas](#cenas_excluir) 
- [Adicionar ou editar rotinas](#rotinas_salvar) 
- [Listar ou pesquisar rotinas](#rotinas_listar) 
- [Excluir uma rotinas](#rotinas_excluir) 



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

## Adicionar ou editar empreendimentos <a name="empreendimentos_salvar"></a>
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

`POST: {host}/empreendimentos/salvar[/{id}]`

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
  "msg": "Empreendimentos foi salvo",
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




## Listar ou pesquisar empreendimentos <a name="empreendimentos_listar"></a>
[^ Topo](#topo) 

Busca um empreendimento pelo nome, usupario_id ou endereco_id
Se não for enviado nenhum dos parâmetros no request, será retornado todos os empreendimentos cadastrados,
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

`GET|POST: {host}/empreendimentos/lista`

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


## Excluir um empreendimento <a name="empreendimentos_excluir"></a>
[^ Topo](#topo) 

Busca um empreendimento pelo ID passado na URL e seta como excluído.
Usuários nível 1 não tem permissão para esta rota.

### Bearer token
 Sim

### Parâmetros

Nenhum parâmetro é enviado 


### Request

`POST: {host}/empreendimentos/excluir/{id}`


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

## Adicionar ou editar dispositivos <a name="dispositivos_salvar"></a>
[^ Topo](#topo) 

Adiciona ou edita um dispositivo.
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

`POST: {host}/dispositivos/salvar[/{id}]`

```
{
	"usuario_id": "1",
	"dispositivo_tipo_id": 2,
	"emrpeendimento_id": 2,
	"nome":" exemplo  de     dispositivo ",
	"marca": "Marca",
	"modelo": "M-1234"
}
```
### Response

```
{
  "status": true,
  "msg": "Dispositivo foi adicionada",
  "data": [
    {
      "id": 4,
      "dispositivo_tipo_id": 2,
      "usuario_id": 1,
      "nome": "Exemplo de dispositivo",
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




## Listar ou pesquisar dispositivos<a name="dispositivos_listar"></a>
[^ Topo](#topo) 

Busca um dispositivo pelo nome, dispositivo_tipo_id, usuario_id, marca ou modelo
Se não for enviado nenhum dos parâmetros no request, será retornado todos os dispositivos cadastrados,
Porem se o Bearer token for de um usuário nível 1, filtrará só os dados do proprio usuário.

### Bearer token
 Sim

### Parâmetros
Parâmetros usados na requisição

| Parâmetro             |Tipo     | Descrição                |
| --------------------- | ------  | -------------------------|
| [dispositivo_tipo_id] | string  | ID do tipo de dispositivo |
| [usuario_id]          | string  | ID de um usuário |
| [nome]                | string  | Nome de um dispositivo |
| [marca]               | string  | Marca de um dispositivo |
| [modelo]              | string  | Modelo de um dispositivo |


### Request

`GET|POST: {host}/dispositivos/lista`

```
{
	"nome":"exemplo"
}

```

### Response

``` 
{
  "status": true,
  "msg": "2 dispositivo(s) encontrado(s)",
  "data": [
    {
      "id": 1,
      "dispositivo_tipo_id": 2,
      "usuario_id": 1,
      "nome": "Exemplo de dispositivo",
      "marca": "Marca",
      "modelo": "M-1234"
    },
    {
      "id": 2,
      "dispositivo_tipo_id": 2,
      "usuario_id": 1,
      "nome": "Nome de outro dispositivo",
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
  "msg": "1 dispositivo(s) encontrado(s)",
  "data": [
    {
      "id": 4,
      "dispositivo_tipo_id": 2,
      "usuario_id": 1,
      "nome": "Exemplo de dispositivo",
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
  "msg": "0 dispositivo(s) encontrado(s)",
  "data": []
}
```

## Excluir um dispositivo <a name="dispositivos_excluir"></a>
[^ Topo](#topo) 

Busca um dispositivo pelo ID passado na URL e seta como excluído.
Usuários nível 1 não tem permissão para esta rota.

### Bearer token
 Sim

### Parâmetros

Nenhum parâmetro é enviado 


### Request

`POST: {host}/dispositivos/excluir/{id}`


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


## Dispositivos/tipo/salvar<a name="dispositivos_tipo_salvar"></a>
[^ Topo](#topo) 

Adiciona ou edita um tipo de dispositivo.
Se ID for passado na URL, faz a busca, caso encontre, faz a atualização dos dados.
Se ID não for passado na URL, faz a adição de um novo registro.


### Bearer token
 Sim

### Parâmetros
Parâmetros usados na requisição

| Parâmetro     | Tipo    | Descrição     |
| ------------- | ------- | -------------------------|
| [nome]        | string  | Nome do dispositivo |
| [descricao]   | string  | Descrição de um tipo de dispositivo |


### Request

`POST: {host}/dispositivos/tipo/salvar[/{id}]`

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
  "msg": "Dispositivo foi adicionada",
  "data": [
    {
      "id": 8,
      "dispositivo_tipo_id": 2,
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



## Dispositivos/tipo/listar<a name="dispositivos_tipo_listar"></a>
[^ Topo](#topo) 

Busca um tipo de dispositivo, nome ou descricao
Se não for enviado nenhum dos parâmetros no request, será retornado todos os usuários cadastrados,
Porem se o Bearer token for de um usuário nível 1, filtrará só os dados do proprio usuário.

### Bearer token
 Sim

### Parâmetros
Parâmetros usados na requisição

| Parâmetro             |Tipo     | Descrição                |
| --------------------- | ------  | -------------------------|
| [nome]                | string  | Nome de um tipo de dispositivo |
| [descricao]          | string  | Descrição de um tipo de dispositivo |


### Request

`GET|POST: {host}/dispositivos/tipo/lista`

```
{
	"nome":"exemplo"
}

```

### Response

``` 
{
  "status": true,
  "msg": "2 tipo(s) de dispositivo(s) encontrado(s)",
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
  "msg": "1 tipo(s) de dispositivo(s) encontrado(s)",
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
  "msg": "0 tipo(s) de dispositivo(s) encontrado(s)",
  "data": []
}
```

## Excluir um tipo de dispositivo <a name="dispositivos_tipo_excluir"></a>
[^ Topo](#topo) 

Busca um tipo de dispositivo pelo ID passado na URL e seta como excluído.
Usuários nível 1 não tem permissão para esta rota.

### Bearer token
 Sim

### Parâmetros

Nenhum parâmetro é enviado 


### Request

`POST: {host}/dispositivos/tipo/excluir/{id}`


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



## Adicionar ou editar cenas<a name="cenas_salvar"></a>
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

`POST: {host}/cenas/salvar[/{id}]`

```
{
	"usuario_id": "1",
	"nome":"Sala de star",
	"configuracoes": [
		{
			"dispositivo_id": 1,
			"state": 1,
			"bright": 80
		},
		{
		"dispositivo_id": 2,
			"state": 1,
			"bright": 50
		},
		{
			"dispositivo_id": 3,
			"state": 0
		},
		{
		  "dispositivo_id": 4,
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
      "configuracoes": "[{\"state\": 1, \"bright\": 80, \"dispositivo_id\": 1}, {\"state\": 1, \"bright\": 50, \"dispositivo_id\": 2}, {\"state\": 0, \"dispositivo_id\": 3}, {\"speed\": 4, \"stare\": 1, \"teperatura\": 23, \"dispositivo_id\": 4}]",
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


## Listar ou pesquisar cenas<a name="cenas_listar"></a>
[^ Topo](#topo) 

Busca uma cena pelo nome ou usuario_id.
Se não for enviado nenhum dos parâmetros no request, será retornado todos as cenas cadastrados,
Porem se o Bearer token for de um usuário nível 1, filtrará só os dados do proprio usuário.

### Bearer token
 Sim

### Parâmetros
Parâmetros usados na requisição

| Parâmetro             |Tipo     | Descrição                |
| --------------------- | ------  | -------------------------|
| [usuario_id]          | string  | ID de um usuário |
| [nome]                | string  | Nome de um dispositivo |


### Request

`GET|POST: {host}/cenas/lista`

```
{
	"nome":"exemplo"
}

```

### Response

``` 
{
  "status": true,
  "msg": "2 cenas(s) encontrado(s)",
  "data": [
    {
      "id": 1,
      "usuario_id": 1,
      "nome": "Exemplo de cena",
      "configuracoes": "[{\"state\": 1, \"bright\": 80, \"dispositivo_id\": 1}, {\"state\": 1, \"bright\": 50, \"dispositivo_id\": 2}, {\"state\": 0, \"dispositivo_id\": 3}, {\"speed\": 4, \"stare\": 1, \"teperatura\": 23, \"dispositivo_id\": 4}]",
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
      "configuracoes": "[{\"state\": 1, \"bright\": 80, \"dispositivo_id\": 1}, {\"state\": 1, \"bright\": 50, \"dispositivo_id\": 2}, {\"state\": 0, \"dispositivo_id\": 3}, {\"speed\": 4, \"stare\": 1, \"teperatura\": 23, \"dispositivo_id\": 4}]",
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
  "msg": "1 cenas(s) encontrado(s)",
  "data": [
    {
      "id": 1,
      "usuario_id": 1,
      "nome": "Exemplo de cena",
      "configuracoes": "[{\"state\": 1, \"bright\": 80, \"dispositivo_id\": 1}, {\"state\": 1, \"bright\": 50, \"dispositivo_id\": 2}, {\"state\": 0, \"dispositivo_id\": 3}, {\"speed\": 4, \"stare\": 1, \"teperatura\": 23, \"dispositivo_id\": 4}]",
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

## Excluir uma cena <a name="cenas_excluir"></a>
[^ Topo](#topo) 

Busca uma cena pelo ID passado na URL e seta como excluído.
Usuários nível 1 não tem permissão para esta rota.

### Bearer token
 Sim

### Parâmetros

Nenhum parâmetro é enviado 


### Request

`POST: {host}/cenas/excluir/{id}`


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


## Adicionar ou editar rotinas<a name="rotinas_salvar"></a>
[^ Topo](#topo) 

Adiciona ou edita uma rotina de uma cena previamente cadastrada.
Se ID for passado na URL, faz a busca, caso encontre, faz a atualização dos dados.
Se ID não for passado na URL, faz a adição de um novo registro.


### Bearer token
 Sim

### Parâmetros
Parâmetros usados na requisição

| Parâmetro     | Tipo    | Descrição     |
| ------------- | ------- | ----------- | --------------|
| [usuario_id]  | string  | ID de um usuário |
| [cena_id]     | string  | ID de um endereço |
| [nome]        | string  | Nome da rotina |
| [horarios]    | string  | Horarios da rotina |
| [datas]       | string  | Datas da rotina |
| [repeticao]   | string  | Repetições da rotina |


### Request

`POST: {host}/rotina/salvar[/{id}]`

```
{
  "usuario_id":"1",
	"cena_id":"1",
  "nome":"Nome da rotina editada2",
  "horarios":"10:00,11:00",
  "datas":"01/05/2022,01/06/2022",
  "repeticao":null	
}
```
### Response

```
{
  "status": true,
  "msg": "Dispositivo foi adicionada",
  "data": [
    {
      "id": 4,
      "dispositivo_tipo_id": 2,
      "usuario_id": 1,
      "nome": "Exemplo de dispositivo",
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


## Listar ou pesquisar rotinas<a name="rotinas_listar"></a>
[^ Topo](#topo) 

Busca uma rotina  nome de usuário, usuario_id ou cena_id
Se não for enviado nenhum dos parâmetros no request, será retornado todos as rotinas cadastrados,
Porem se o Bearer token for de um usuário nível 1, filtrará só os dados do proprio usuário.

### Bearer token
 Sim

### Parâmetros
Parâmetros usados na requisição

| Parâmetro             |Tipo     | Descrição                |
| --------------------- | ------  | -------------------------|
| [nome]          | string  | ID de um usuário |
| [usuario_id] | string  | ID do tipo de dispositivo |
| [cena_id]          | string  | ID de um usuário |


### Request

`GET|POST: {host}/dispositivos/lista`

```
{
	"nome":"exemplo"
}

```

### Response

``` 
{
  "status": true,
  "msg": "2 rotinas(s) encontrado(s)",
  "data": [
    {
      "id": 13,
      "usuario_id": 1,
      "nome": "Exemplo de rotina",
      "horarios": "11:00,11:00",
      "datas": "2022-06-01,2022-06-01",
      "repeticao": null,
      "ativo": null,
      "excluido": "N",
      "excluido_por": null,
      "data_excluido": null,
      "data_insert": "2022-07-25 17:25:32",
      "data_update": null
    },
    {
      "id": 14,
      "usuario_id": 1,
      "nome": "Testes de rotina",
      "horarios": "11:00,11:00",
      "datas": "2022-06-01,2022-06-01",
      "repeticao": null,
      "ativo": null,
      "excluido": "N",
      "excluido_por": null,
      "data_excluido": null,
      "data_insert": "2022-07-25 17:25:41",
      "data_update": null
    }
  ]
}
```

Ou

```
{
  "status": true,
  "msg": "1 rotinas(s) encontrado(s)",
  "data": [
    {
      "id": 13,
      "usuario_id": 1,
      "nome": "Exemplo de rotina",
      "horarios": "11:00,11:00",
      "datas": "2022-06-01,2022-06-01",
      "repeticao": null,
      "ativo": null,
      "excluido": "N",
      "excluido_por": null,
      "data_excluido": null,
      "data_insert": "2022-07-25 17:25:32",
      "data_update": null
    }
  ]
}
``` 

Ou

```
{
  "status": true,
  "msg": "0 rotinas(s) encontrado(s)",
  "data": []
}
```

## Excluir uma rotina <a name="rotinas_excluir"></a>
[^ Topo](#topo) 

Busca uma rotina pelo ID passado na URL e seta como excluído.
Usuários nível 1 não tem permissão para esta rota.

### Bearer token
 Sim

### Parâmetros

Nenhum parâmetro é enviado 


### Request

`POST: {host}/rotinas/excluir/{id}`


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
