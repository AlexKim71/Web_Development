import React from "react";
import { request } from "./api.js";

class Room extends React.Component {
  render() {
    const { room, onRemove, disabled } = this.props;
    return (
      <li className="room-item" style={{ marginBottom: "10px", padding: "10px", border: "1px solid #ccc" }}>
        <div>
          <strong>№{room.number}</strong> — {room.category} (Поверх: {room.floor}, Місткість: {room.capacity} осіб)
          <div>
            <span>Ціна: {room.pricePerNight.toLocaleString("uk-UA")} грн/ніч | </span>
            <span style={{ color: room.isAvailable ? "green" : "red", fontWeight: "bold" }}>
              {room.isAvailable ? "Доступний" : "Зайнятий"}
            </span>
          </div>
        </div>
        <button
          type="button"
          disabled={disabled}
          onClick={() => onRemove(room)}
          style={{ marginTop: "5px" }}
        >
          Видалити
        </button>
      </li>
    );
  }
}

class RoomForm extends React.Component {
  state = {
    number: "",
    category: "Стандарт",
    capacity: "2",
    floor: "1",
    pricePerNight: "",
    isAvailable: true,
    error: ""
  };

  onSubmit = async (event) => {
    event.preventDefault();
    if (this.props.disabled) return;

    const number = this.state.number.trim();
    const category = this.state.category.trim();
    const capacity = Number(this.state.capacity);
    const floor = Number(this.state.floor);
    const pricePerNight = Number(this.state.pricePerNight);
    const isAvailable = this.state.isAvailable;

    if (!number || number.length > 10) {
      this.setState({ error: "Номер кімнати має бути від 1 до 10 символів." });
      return;
    }
    if (capacity < 1 || capacity > 8) {
      this.setState({ error: "Місткість: від 1 до 8 осіб." });
      return;
    }
    if (floor < 0 || floor > 50) {
      this.setState({ error: "Поверх: від 0 до 50." });
      return;
    }
    if (pricePerNight < 1 || pricePerNight > 100000) {
      this.setState({ error: "Вартість ночі: від 1 до 100000 грн." });
      return;
    }

    this.setState({ error: "" });
    const saved = await this.props.onRoomSubmit({
      number,
      category,
      capacity,
      floor,
      pricePerNight,
      isAvailable
    });

    if (saved) {
      this.setState({
        number: "",
        category: "Стандарт",
        capacity: "2",
        floor: "1",
        pricePerNight: "",
        isAvailable: true,
        error: ""
      });
    }
  };

  render() {
    return (
      <form onSubmit={this.onSubmit} noValidate style={{ marginBottom: "20px" }}>
        <fieldset disabled={this.props.disabled} style={{ padding: "15px" }}>
          <legend><strong>Додати новий номер готелю</strong></legend>
          <div style={{ marginBottom: "10px" }}>
            <label htmlFor="number">Номер кімнати: </label>
            <input
              id="number"
              type="text"
              maxLength={10}
              value={this.state.number}
              onChange={(e) => this.setState({ number: e.target.value })}
              required
            />
          </div>

          <div style={{ marginBottom: "10px" }}>
            <label htmlFor="category">Категорія: </label>
            <select
              id="category"
              value={this.state.category}
              onChange={(e) => this.setState({ category: e.target.value })}
            >
              <option value="Стандарт">Стандарт</option>
              <option value="Напівлюкс">Напівлюкс</option>
              <option value="Люкс">Люкс</option>
              <option value="Апартаменти">Апартаменти</option>
            </select>
          </div>

          <div style={{ marginBottom: "10px" }}>
            <label htmlFor="capacity">Місткість (1-8 осіб): </label>
            <input
              id="capacity"
              type="number"
              min="1"
              max="8"
              value={this.state.capacity}
              onChange={(e) => this.setState({ capacity: e.target.value })}
              required
            />
          </div>

          <div style={{ marginBottom: "10px" }}>
            <label htmlFor="floor">Поверх (0-50): </label>
            <input
              id="floor"
              type="number"
              min="0"
              max="50"
              value={this.state.floor}
              onChange={(e) => this.setState({ floor: e.target.value })}
              required
            />
          </div>

          <div style={{ marginBottom: "10px" }}>
            <label htmlFor="price">Вартість ночі (грн): </label>
            <input
              id="price"
              type="number"
              min="1"
              max="100000"
              step="0.01"
              value={this.state.pricePerNight}
              onChange={(e) => this.setState({ pricePerNight: e.target.value })}
              required
            />
          </div>

          <div style={{ marginBottom: "10px" }}>
            <label>
              <input
                type="checkbox"
                checked={this.state.isAvailable}
                onChange={(e) => this.setState({ isAvailable: e.target.checked })}
              />{" "}
              Доступний для бронювання
            </label>
          </div>

          <button type="submit">Зберегти запис</button>
        </fieldset>
        {this.state.error && <p role="alert" style={{ color: "red" }}>{this.state.error}</p>}
      </form>
    );
  }
}

export class RoomsList extends React.Component {
  state = {
    rooms: [],
    loading: true,
    busy: false,
    error: "",
    searchQuery: "",
    filterCategory: "",
    filterAvailable: "all",
    sortByPrice: "asc"
  };

  pending = false;

  componentDidMount() {
    this.loadData();
  }

  loadData = async () => {
    if (this.pending) return;
    this.pending = true;
    this.setState({ loading: true, error: "" });
    try {
      const rooms = await request("GET", this.props.apiUrl);
      if (!Array.isArray(rooms)) throw new Error("Очікувався список.");
      this.setState({ rooms });
    } catch (error) {
      this.setState({ error: error.message });
    } finally {
      this.pending = false;
      this.setState({ loading: false });
    }
  };

  onAddRoom = async (input) => {
    if (this.pending) return false;
    this.pending = true;
    this.setState({ busy: true, error: "" });
    try {
      const room = await request("POST", this.props.apiUrl, input);
      this.setState((s) => ({ rooms: [...s.rooms, room] }));
      return true;
    } catch (error) {
      this.setState({ error: error.message });
      return false;
    } finally {
      this.pending = false;
      this.setState({ busy: false });
    }
  };

  onRemoveRoom = async (room) => {
    if (this.pending || !window.confirm(`Видалити номер №${room.number}?`)) {
      return;
    }
    this.pending = true;
    this.setState({ busy: true, error: "" });
    try {
      const url = `${this.props.apiUrl}/${encodeURIComponent(room.id)}`;
      await request("DELETE", url);
      this.setState((s) => ({
        rooms: s.rooms.filter((r) => r.id !== room.id)
      }));
    } catch (error) {
      this.setState({ error: error.message });
    } finally {
      this.pending = false;
      this.setState({ busy: false });
    }
  };

  getFilteredRooms = () => {
    const { rooms, searchQuery, filterCategory, filterAvailable, sortByPrice } = this.state;

    return rooms
      .filter((r) => {
        const matchesSearch = r.number.toLowerCase().includes(searchQuery.toLowerCase().trim());
        const matchesCategory = filterCategory ? r.category === filterCategory : true;
        const matchesAvailable =
          filterAvailable === "all"
            ? true
            : filterAvailable === "available"
            ? r.isAvailable
            : !r.isAvailable;
        return matchesSearch && matchesCategory && matchesAvailable;
      })
      .sort((a, b) =>
        sortByPrice === "asc" ? a.pricePerNight - b.pricePerNight : b.pricePerNight - a.pricePerNight
      );
  };

  render() {
    const { loading, busy, error } = this.state;
    const disabled = loading || busy;
    const filteredRooms = this.getFilteredRooms();

    const totalAvailableCapacity = filteredRooms
      .filter((r) => r.isAvailable)
      .reduce((sum, r) => sum + r.capacity, 0);

    return (
      <main style={{ padding: "20px", fontFamily: "Arial, sans-serif", maxWidth: "800px", margin: "0 auto" }}>
        <h1>Каталог готельних номерів (Варіант 4)</h1>
        <RoomForm disabled={disabled} onRoomSubmit={this.onAddRoom} />

        <hr style={{ margin: "20px 0" }} />
        <h2>Пошук та фільтрація</h2>
        <div style={{ display: "flex", gap: "10px", marginBottom: "15px", flexWrap: "wrap" }}>
          <input
            type="text"
            placeholder="Пошук за номером..."
            value={this.state.searchQuery}
            onChange={(e) => this.setState({ searchQuery: e.target.value })}
          />
          <select
            value={this.state.filterCategory}
            onChange={(e) => this.setState({ filterCategory: e.target.value })}
          >
            <option value="">Усі категорії</option>
            <option value="Стандарт">Стандарт</option>
            <option value="Напівлюкс">Напівлюкс</option>
            <option value="Люкс">Люкс</option>
            <option value="Апартаменти">Апартаменти</option>
          </select>
          <select
            value={this.state.filterAvailable}
            onChange={(e) => this.setState({ filterAvailable: e.target.value })}
          >
            <option value="all">Усі номери</option>
            <option value="available">Тільки доступні</option>
            <option value="unavailable">Тільки зайняті</option>
          </select>
          <select
            value={this.state.sortByPrice}
            onChange={(e) => this.setState({ sortByPrice: e.target.value })}
          >
            <option value="asc">Ціна: за зростанням</option>
            <option value="desc">Ціна: за спаданням</option>
          </select>
        </div>

        <button onClick={this.loadData} disabled={disabled} style={{ marginBottom: "15px" }}>
          Оновити список
        </button>

        <div style={{ padding: "10px", background: "#f9f9f9", border: "1px solid #ddd", marginBottom: "15px" }}>
          <strong>Підсумки вибірки:</strong>
          <p>Кількість показаних кімнат: {filteredRooms.length}</p>
          <p>Сумарна місткість доступних серед них: {totalAvailableCapacity} осіб</p>
        </div>

        {busy && <p role="status">Виконується запит...</p>}
        {error && <p role="alert" style={{ color: "red" }}>{error}</p>}
        {!loading && !error && filteredRooms.length === 0 && <p>Нічого не знайдено.</p>}

        <ul style={{ listStyle: "none", padding: 0 }}>
          {filteredRooms.map((room) => (
            <Room
              key={room.id}
              room={room}
              disabled={disabled}
              onRemove={this.onRemoveRoom}
            />
          ))}
        </ul>
      </main>
    );
  }
}
