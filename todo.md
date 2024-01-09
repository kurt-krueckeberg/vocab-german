## TODOES

## Problem of noun definition returned for verbs and definition for different verbs are also returned.

### Example One: noun definitions returned for verb

For the verb `aussehen`, definitions of `Aussehen` are returned. `aussehen` is not really a dictionary verb.
It is an expression used with adjectives like gut, schlecht, etc. Aussehen is in the dictionary.

`$defnsInterface->matches['source']['pos'] == 'noun'`  

and 

`$defnsInterface->matches['source']['lemma'] == 'Aussehen'`

The way the code can tell that definitions for `Aussehen` were returned for the input word `aussehen` is

*  `ctype_upper(defnsInterface->matches['source']['lemma'][0]) && ctype_lower(($word[0])`
* `strcmp(defnsInterface->matches['source']['lemma'][0], $word) !== 0`
  
Recurse in this case and insert the noun?

### Prefix versions of non-prefix verb returned

Take `gehen`. Definitions for all its prefixed forms get returned. The matches array is very large. We need to know
the current of matches and whether

`$defnsInterface->matches[$current_index]['source']['lemma'] == $word.

