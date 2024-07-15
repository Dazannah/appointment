<x-app-layout>
  <form action="/make-reservation" method="post">
    @csrf
    <input type="datetime-local" name="start" id="start" required>
    <input type="datetime-local" name="end" id="end" required>
    <input type="text" name="title" id="title" required>
    <input type="submit" value="Küldés">
  </form>

</x-app-layout>