using Microsoft.AspNetCore.Mvc;
using AngularApi.Models;
namespace AngularApi.Controllers;

[ApiController]
[Route("api/[controller]")]
public sealed class RoomsController : ControllerBase
{
    private static readonly object Gate = new();
    private static readonly List<Room> Data = new()
    {
        Seed("001", "Стандарт", 2, 0, 1000m, true),
        Seed("101", "Стандарт", 2, 1, 1200m, true),
        Seed("102", "Стандарт", 3, 1, 1500m, false),
        Seed("201", "Комфорт", 2, 2, 2100m, true),
        Seed("202", "Комфорт", 3, 2, 2500m, true),
        Seed("203", "Комфорт", 2, 2, 2300m, false),
        Seed("301", "Сімейний", 4, 3, 3200m, true),
        Seed("302", "Сімейний", 6, 3, 4500m, true),
        Seed("401", "Люкс", 2, 4, 5800m, true),
        Seed("402", "Люкс", 4, 4, 7500m, false)
    };

    // Початкові навчальні дані; ідентифікатор створює сервер.
    private static Room Seed(string number, string category, int capacity,
        int floor, decimal price, bool available) => new()
    {
        Id = Guid.NewGuid().ToString(),
        Number = number,
        Category = category,
        Capacity = capacity,
        Floor = floor,
        PricePerNight = price,
        IsAvailable = available
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
        if (number.Length < 1 || number.Length > 10)
            return BadRequest(new { detail =
                "Номер після обрізання пробілів: 1–10 символів." });
        if (decimal.Round(input.PricePerNight, 2) != input.PricePerNight)
            return BadRequest(new { detail =
                "Вартість ночі: не більше двох знаків після коми." });
        lock (Gate)
        {
            if (Data.Any(r => string.Equals(r.Number, number,
                    StringComparison.OrdinalIgnoreCase)))
                return Conflict(new { detail =
                    "Кімната з таким номером вже існує." });
            var room = new Room
            {
                Id = Guid.NewGuid().ToString(),
                Number = number,
                Category = input.Category,
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
            if (room is null) return NotFound(new
                { detail = "Запис не знайдено." });
            Data.Remove(room);
            return Ok(room);
        }
    }
}
