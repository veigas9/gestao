<div class="form-row">
    <div class="form-group col-md-6">
        <label for="company_name">Razão social *</label>
        <input type="text" id="company_name" name="company_name"
               value="{{ old('company_name', $store->company_name) }}"
               class="form-control" required>
    </div>
    <div class="form-group col-md-6">
        <label for="trade_name">Nome fantasia</label>
        <input type="text" id="trade_name" name="trade_name"
               value="{{ old('trade_name', $store->trade_name) }}"
               class="form-control">
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-4">
        <label for="cnpj">CNPJ *</label>
        <input type="text" id="cnpj" name="cnpj"
               value="{{ old('cnpj', $store->cnpj) }}"
               class="form-control" required>
    </div>
    <div class="form-group col-md-4">
        <label for="ie">Inscrição Estadual</label>
        <input type="text" id="ie" name="ie"
               value="{{ old('ie', $store->ie) }}"
               class="form-control">
    </div>
    <div class="form-group col-md-4">
        <label for="tax_regime">Regime tributário *</label>
        @php
            $taxRegime = old('tax_regime', $store->tax_regime);
        @endphp
        <select id="tax_regime" name="tax_regime" class="form-control" required>
            <option value="MEI" @selected($taxRegime === 'MEI')>MEI</option>
            <option value="SN" @selected($taxRegime === 'SN')>Simples Nacional</option>
            <option value="LRP" @selected($taxRegime === 'LRP')>Lucro Presumido/Real</option>
        </select>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-4">
        <label for="cnae">CNAE principal</label>
        <input type="text" id="cnae" name="cnae"
               value="{{ old('cnae', $store->cnae) }}"
               class="form-control">
    </div>
    <div class="form-group col-md-8">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email"
               value="{{ old('email', $store->email) }}"
               class="form-control">
    </div>
</div>

<hr>

<h5>Endereço</h5>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="street">Logradouro *</label>
        <input type="text" id="street" name="street"
               value="{{ old('street', $store->street) }}"
               class="form-control" required>
    </div>
    <div class="form-group col-md-2">
        <label for="number">Número</label>
        <input type="text" id="number" name="number"
               value="{{ old('number', $store->number) }}"
               class="form-control">
    </div>
    <div class="form-group col-md-4">
        <label for="complement">Complemento</label>
        <input type="text" id="complement" name="complement"
               value="{{ old('complement', $store->complement) }}"
               class="form-control">
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-4">
        <label for="neighborhood">Bairro</label>
        <input type="text" id="neighborhood" name="neighborhood"
               value="{{ old('neighborhood', $store->neighborhood) }}"
               class="form-control">
    </div>
    <div class="form-group col-md-4">
        <label for="city">Cidade *</label>
        <input type="text" id="city" name="city"
               value="{{ old('city', $store->city) }}"
               class="form-control" required>
    </div>
    <div class="form-group col-md-2">
        <label for="state">UF *</label>
        <input type="text" id="state" name="state"
               value="{{ old('state', $store->state ?? 'RS') }}"
               class="form-control" maxlength="2" required>
    </div>
    <div class="form-group col-md-2">
        <label for="zip_code">CEP</label>
        <input type="text" id="zip_code" name="zip_code"
               value="{{ old('zip_code', $store->zip_code) }}"
               class="form-control">
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-4">
        <label for="city_ibge_code">Código IBGE do município</label>
        <input type="text" id="city_ibge_code" name="city_ibge_code"
               value="{{ old('city_ibge_code', $store->city_ibge_code) }}"
               class="form-control">
    </div>
    <div class="form-group col-md-4">
        <label for="phone">Telefone</label>
        <input type="text" id="phone" name="phone"
               value="{{ old('phone', $store->phone) }}"
               class="form-control">
    </div>
</div>

<hr>

<h5>NF-e</h5>
<div class="form-row">
    <div class="form-group col-md-4">
        <label for="nfe_environment">Ambiente *</label>
        @php
            $env = old('nfe_environment', $store->nfe_environment ?? 'homologacao');
        @endphp
        <select id="nfe_environment" name="nfe_environment" class="form-control" required>
            <option value="homologacao" @selected($env === 'homologacao')>Homologação</option>
            <option value="producao" @selected($env === 'producao')>Produção</option>
        </select>
    </div>
    <div class="form-group col-md-2">
        <label for="nfe_series">Série *</label>
        <input type="text" id="nfe_series" name="nfe_series"
               value="{{ old('nfe_series', $store->nfe_series ?? '1') }}"
               class="form-control" required>
    </div>
    <div class="form-group col-md-6">
        <label for="nfe_cert_path">Caminho do certificado A1 (.pfx)</label>
        <input type="text" id="nfe_cert_path" name="nfe_cert_path"
               value="{{ old('nfe_cert_path', $store->nfe_cert_path) }}"
               class="form-control"
               placeholder="Ex.: storage/certs/certificado.pfx">
        <small class="form-text text-muted">
            A senha do certificado será configurada apenas no arquivo .env (NFE_CERT_PASSWORD).
        </small>
    </div>
</div>


