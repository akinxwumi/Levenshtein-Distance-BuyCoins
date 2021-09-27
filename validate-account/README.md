Spelling errors are classified into 4 descriptive types: 

- **Deletion:** Removing one letter
- **Insertion:** Adding one letter
- **Substitution:** Changing one letter to another
- **Transposition:** Swapping two adjacent letters

The Levenshtein Distance algorithm measures the similarity between two strings A and B by computing as a distance the number of insertions, deletions, or substitutions of single characters required to transform A into B while the Damerau–Levenshtein Distance algorithm computes all these but also the number of transpositions. In this specific scenario, we are optimizing for the **Deletion types** spelling errors so the Levenshtein Distance algorithm might relatively be more efficient.

**GraphQL Endpoint**
https://glacial-everglades-33318.herokuapp.com/graphql-playground

**Assumption**
I assumed that I don't need to write a test for the levenstein-distance implementation since I used an inbuilt PHP function
