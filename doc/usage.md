# Uso da API iGo Pass
- [login/auth](#login_auth) 
- [usuarios/listar](#usuarios_listar) 
- [usuarios/salvar](#usuarios_salvar) 
- [usuarios/pessoas/listar](#usuarios_pessoas_listar) 
- [usuarios/pessoas/salvar](#usuarios_pessoas_salvar) 
- [enderecos/listar](#enderecos_listar) 
- [enderecos/salvar](#enderecos_salvar) 
- [empreendimentos/listar](#empreendimetos_listar) 
- [empreendimentos/salvar](#empreendimetos_salvar) 
- [dispositivos/listar](#dispositivos_listar) 
- [dispositivos/salvar](#dispositivos_salvar) 
- [cenas/listar](#cenas_listar) 
- [cenas/salvar](#cenas_salvar) 
- [rotinas/listar](#rotinas_listar) 
- [rotinas/salvar](#rotinas_salvar) 



## login/auth
<a name="login_auth"></a>
Faz autenticação de um usuário atravez de usuario e senha e retorna os dados do usuário

### Bearer token
 Não

### Parametros
Parâmetros usados na requisição

| Parâmetro |Tipo     | Descrição        |
| --------- | ------ | ----------- | ---------------- |
| [usuario] | string  | Username |
| [senha]   | string | Obrigatório com usuario | Senha do usuário |
| [email]   | string  | E-mail de autenticação do usuário |
| [celular] | string  | celular de autenticação do usuário |


### Request

**[POST]{{ url }}/users/login/auth**

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

## usuarios/listar
<a name="usuarios_listar"></a>
Busca um usuário pelo nome de usuário, e-mail ou celular
Se não for enviado nenhum dos parâmetros no request, será retornado todos os usuários cadastrados,
Porem se o Bearer token for de um usuário nivel 1, filtrará só os dados do proprio usuário.

### Bearer token
 Sim

### Parametros
Parâmetros usados na requisição

| Parâmetro |Tipo     | Descrição     |
| --------- | ------ | ----------- | --------------|
| [usuario] | string  | Username de um usuário |
| [email]   | string  | E-mail de autenticação de um usuário |
| [celular] | string  | Celular de autenticação de um usuário |



### Request

**[GET|POST]{{ url }}/usuarios/listar**

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


## token/save
<a name="token_save"></a>
Busca um usuário pelo Bearer token e salva o push token deste usuário

### Bearer token
Sim

### Parametros
Parâmetros usados na requisição

| Parâmetro |Tipo     | Descrição             |
| --------- | ------ | ----------- | --------------------- |
| [token]   | string | Obrigatório | Push token do usuário |


### Request

**[POST]{{ url }}/users/token/save**

```
{
	"token": "e04398300558cb210194f954bb44b6ef"
}
```
### Response
```
{
  "status": true,
  "msg": " push tokens foi adicionado",
  "data": {
    "id": 5
  }
}
```

ou

```
{
  "status": true,
  "msg": " push token foi atualizado",
  "data": {
    "id": 4
  }
}
```


## usuarios/salvar
<a name="usuarios_salvar"></a>

### Adicionar ou editar um novo usuário

### Bearer token
 Sim

### Parametros
Parâmetros usados na requisição

| Parâmetro   | Tipo    | Descrição     |
| ----------- | ------ | ----------- | --------------|
| [usuario]   | string  | Username de um usuário |
| [email]     | string  | E-mail de autenticação de um usuário |
| [celular]   | string  | Celular de autenticação de um usuário |
| [pessoa_id] | string  | Id do cadastro da pessoa |
| [nivel]     | string  | Nivel do usuário: 1: Cliente; 2: Admim basico; 3: Admim super |


### Request

**[POST]{{ url }}/usuarios/salvar[/{id}]**

```
{
	"usuario": "nome.usuario",
  "senha": "senhaSecreta",
  "email":"email@exemplo.com",
  "celular":"99 99999-9999",
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



## usuarios/pessoa/listar
<a name="usuarios_pessoa_listar"></a>

Busca um usuário pelo nome de usuário, e-mail ou celular
Se não for enviado nenhum dos parâmetros no request, será retornado todos os usuários cadastrados,
Porem se o Bearer token for de um usuário nivel 1, filtrará só os dados do proprio usuário.

### Bearer token
 Sim

### Parametros
Parâmetros usados na requisição

| Parâmetro |Tipo     | Descrição     |
| --------- | ------ | ----------- | --------------|
| [usuario] | string  | Username de um usuário |
| [email]   | string  | E-mail de autenticação de um usuário |
| [celular] | string  | Celular de autenticação de um usuário |


### Request

**[GET|POST]{{ url }}/usuarios/pessoa/lista**

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


## usuarios/pessoa/salvar
<a name="usuarios__pessoa_salvar"></a>

### Adicionar um novo usuário

### Bearer token
 Sim

### Parametros
Parâmetros usados na requisição

| Parâmetro       | Tipo   | Descrição |
| --------------- | ------ | -------------------------|
| [endereco_id]   | string | ID de um endereço cadastrado |
| [nome]          | string | Nome da pessoa |
| [cpf_cnpj]      | string | CPF ou CNPJ da pessoa  |
| [documento]     | string | Documento de identificação ou Inscrição estadual |
| [orgao_emissor] | string | Órgão emissor do documento de indentificação |


### Request

**[POST]{{ url }}/usuarios/pessoa/salvar**

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

{
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
}



## endereço/salvar
<a name="endereco_salvar"></a>

### Adicionar ou editar um endereço

### Bearer token
 Sim

### Parametros
Parâmetros usados na requisição

| Parâmetro       | Tipo   | Descrição |
| --------------- | ------ | -------------------------|
| [endereco_id]   | string | ID de um endereço cadastrado |
| [nome]          | string | Nome da pessoa |
| [cpf_cnpj]      | string | CPF ou CNPJ da pessoa  |
| [documento]     | string | Documento de identificação ou Inscrição estadual |
| [orgao_emissor] | string | Órgão emissor do documento de indentificação |


### Request

**[POST]{{ url }}/usuarios/pessoa/salvar[/{id}]**

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




## edereços/listar
<a name="usuarios_listar"></a>
Busca um usuário pelo nome de usuário, e-mail ou celular
Se não for enviado nenhum dos parâmetros no request, será retornado todos os usuários cadastrados,
Porem se o Bearer token for de um usuário nivel 1, filtrará só os dados do proprio usuário.

### Bearer token
 Sim

### Parametros
Parâmetros usados na requisição

| Parâmetro |Tipo     | Descrição     |
| --------- | ------ | ----------- | --------------|
| [usuario] | string  | Username de um usuário |
| [email]   | string  | E-mail de autenticação de um usuário |
| [celular] | string  | Celular de autenticação de um usuário |



### Request

**[GET|POST]{{ url }}/enderecos/listar**

```
{
 "logradouro": "Rua Nome",
}
```

### Response


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




## empreendimentos/salvar
<a name="usuarios_salvar"></a>

### Adicionar ou editar um novo usuário

### Bearer token
 Sim

### Parametros
Parâmetros usados na requisição

| Parâmetro   | Tipo    | Descrição     |
| ----------- | ------ | ----------- | --------------|
| [usuario]   | string  | Username de um usuário |
| [email]     | string  | E-mail de autenticação de um usuário |
| [celular]   | string  | Celular de autenticação de um usuário |
| [pessoa_id] | string  | Id do cadastro da pessoa |
| [nivel]     | string  | Nivel do usuário: 1: Cliente; 2: Admim basico; 3: Admim super |


### Request

**[POST]{{ url }}/usuarios/salvar[/{id}]**

```
{
	"usuario": "nome.usuario",
  "senha": "senhaSecreta",
  "email":"email@exemplo.com",
  "celular":"99 99999-9999",
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

