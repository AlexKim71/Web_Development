using Microsoft.AspNetCore.Mvc;
using ReactApp.Models;

namespace ReactApp.Controllers;

[ApiController]
[Route("api/[controller]")]
public sealed class RoomsController : ControllerBase
{
    private static readonly object Gate = new();
    private static readonly List<Room> Data = new()
    {
        new() { Id = Guid.NewGuid().ToString(), Number = "101", Category = "Стандарт", Capacity = 2, Floor = 1, PricePerNight = 1200, IsAvailable = true },
        new() { Id = Guid.NewGuid().ToString(), Number = "102", Category = "Стандарт", Capacity = 1, Floor = 1, PricePerNight = 900, IsAvailable = false },
        new() { Id = Guid.NewGuid().ToString(), Number = "201", Category = "Напівлюкс", Capacity = 3, Floor = 2, PricePerNight = 2500, IsAvailable = true },
        new() { Id = Guid.NewGuid().ToString(), Number = "202", Category = "Люкс", Capacity = 4, Floor = 2, PricePerNight = 4500, IsAvailable = true },
        new() { Id = Guid.NewGuid().ToString(), Number = "301", Category = "Стандарт", Capacity = 2, Floor = 3, PricePerNight = 1300, IsAvailable = true },
        new() { Id = Guid.NewGuid().ToString(), Number = "302", Category = "Апартаменти", Capacity = 6, Floor = 3, PricePerNight = 7000, IsAvailable = false },
        new() { Id = Guid.NewGuid().ToString(), Number = "001", Category = "Стандарт", Capacity = 2, Floor = 0, PricePerNight = 1000, IsAvailable = true },
        new() { Id = Guid.NewGuid().ToString(), Number = "401", Category = "Люкс", Capacity = 2, Floor = 4, PricePerNight = 5000, IsAvailable = true }
    };

    [HttpGet]
    public ActionResult<Room[]> Get()
    {
        lock (Gate) { return Ok(Data.ToArray()); }
    }

    [HttpPost]
    public ActionResult<Room> Post([FromBody] RoomInput input)
    {
        string number = input.Number.Trim();
        if (string.IsNullOrEmpty(number) || number.Length > 10)
            return BadRequest(new { detail = "Номер кімнати: від 1 до 10 символів." });

        lock (Gate)
        {
            if (Data.Any(r => string.Equals(r.Number, number, StringComparison.OrdinalIgnoreCase)))
                return Conflict(new { detail = "Кімната з таким номером вже існує." });

            var room = new Room
            {
                Id = Guid.NewGuid().ToString(),
                Number = number,
                Category = input.Category.Trim(),
                Capacity = input.Capacity,
                Floor = input.Floor,
                PricePerNight = input.PricePerNight,
                IsAvailable = input.IsAvailable
            };

            Data.Add(room);
            return Ok(room);
        }
    }

    [HttpDelete("{id}")]
    public ActionResult<Room> Delete(string id)
    {
        lock (Gate)
        {
            var room = Data.FirstOrDefault(r => r.Id == id);
            if (room is null) return NotFound(new { detail = "Запис не знайдено." });

            Data.Remove(room);
            return Ok(room);
        }
    }
}
