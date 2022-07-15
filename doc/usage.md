# Uso da API iGo Pass
- [login/auth](#login_auth) 
- [login/check](#login_check) 
- [token/save](#token_save) 


## login/auth
<a name="login_auth"></a>
Faz autenticação de um usuário atravez de usuario e senha e retorna os dados do usuário

### Bearer token
 Não

### Parametros
Parâmetros usados na requisição

| Parâmetro |Tipo    | Necessidade | Descrição        |
| --------- | ------ | ----------- | ---------------- |
| [usuario] | string | Obrigatório | Login do usuário |
| [senha]   | string | Obrigatório | Senha do usuário |


### Request

**[POST]{{ url }}/users/login/auth**

```
{
	"usuario": "nome.usuarios",
	"senha": "senhaSecreta"
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
  "msg": null,
  "data": [
    {
      "usuario": "nome.usuario",
      "nome": "Nome Usuário",
      "token": "VHJkUW84b05mVW55dD",
      "email": "nome.usuario@exemplo.com.br",
      "celular": "449900000000",
      "admin": "S",
      "nivel": 5,
      "logo": ""
    }
  ]
}
```

## login/check
<a name="login_check"></a>
Busca um usuário pelo nome de usuário

### Bearer token
 Sim

### Parametros
Parâmetros usados na requisição

| Parâmetro |Tipo    | Necessidade | Descrição     |
| --------- | ------ | ----------- | --------------|
| [usuario] | string | Opcional | Login do usuário |


### Request

**[GET|POST]{{ url }}/users/login/check**

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
```
{
  "status": true,
  "msg": "1 usuário(s) encontrado(s)",
  "data": [
    {
      "usuario": "nome.usuario",Request
      "nome": "Nome Usuário",
      "token": "VHJkUW84b05mVW55dD",
      "email": "nome.usuario@exemplo.com.br",
      "celular": "449900000000",
      "admin": "S",
      "nivel": 5,
      "logo": ""
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

| Parâmetro |Tipo    | Necessidade | Descrição             |
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