function construirBludjaund(subruta) {
    return new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '',
        remote: {
          url: rootURL + subruta + '%QUERY',
          wildcard: '%QUERY'
        }
      });
}